<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\VerifyEmailLink;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah']);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Berhasil Login',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Berhasil logout']);
    }


    public function register(RegisterRequest $request)
    {
        

        $defaultRoleId   = Role::where('name', 'user')->value('id')
            ?? Role::firstOrCreate(['name' => 'user'])->id;

        // Ambil default status = "Pending" kalau tidak ada input
        $defaultStatusId = Status::firstOrCreate(['status' => 'Pending'])->id;

        $user = DB::transaction(function () use ($request, $defaultRoleId, $defaultStatusId) {
            return User::create([
                'fullname'          => $request->fullname,
                'username'          => $request->username,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'role_id'           => $request->role_id   ?? $defaultRoleId,
                'status_id'         => $request->status_id ?? $defaultStatusId,
                'email_verified_at' => null,
            ]);
        });

        // Buat signed URL
        $verificationUrl = URL::temporarySignedRoute(
            'api.verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
        );

        // Ambil query string dari signed URL
        $queryString = parse_url($verificationUrl, PHP_URL_QUERY);

        // Susun link FRONTEND + tempel query signed
        $frontendBase = rtrim(config('app.frontend_url', env('APP_FRONTEND_URL', 'http://localhost:3000')), '/');
        $frontendLink = $frontendBase . '/verify-email' . ($queryString ? ('?' . $queryString) : '');

        //  Kirim link FRONTEND di email verifikasi
        DB::afterCommit(function () use ($user, $frontendLink) {
            Mail::to($user->email)->queue(new VerifyEmailLink($user, $frontendLink));
        });

        // Token API
        // $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message'      => 'Registrasi berhasil, silakan cek email untuk verifikasi.',
        ], 201);
    }
}
