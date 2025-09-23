<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\VerifyEmailLink;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        // Ambil default role = "user" kalau tidak ada input
        $defaultRoleId = Role::firstOrCreate(['name' => 'user'])->id;

        // Ambil default status = "Pending" kalau tidak ada input
        $defaultStatusId = Status::firstOrCreate(['status' => 'Pending'])->id;

        // Buat user baru
        $user = User::create([
            'fullname'          => $request->fullname,
            'username'          => $request->username,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role_id'           => $request->role_id ?? $defaultRoleId,
            'status_id'         => $request->status_id ?? $defaultStatusId,
            'email_verified_at' => null,
        ]);

        // Buat signed URL
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id'   => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        // Kirim email verifikasi
        Mail::to($user->email)->send(new VerifyEmailLink($user, $verificationUrl));

        // Buat token API
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'      => 'Registrasi berhasil, silakan cek email untuk verifikasi.',
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ], 201);
    }
}
