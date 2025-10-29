<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VerifyEmailLink;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class EmailVerificationController extends Controller
{
    // GET /api/email/verify?id=&hash=&expires=&signature=
    public function verify(Request $request)
    {
        $request->validate([
            'id'   => ['required', 'integer', 'exists:users,id'],
            'hash' => ['required', 'string'],
        ]);

        $user = User::findOrFail($request->id);

        if (!hash_equals($request->hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification hash.'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['message' => 'Email verified successfully.'], 200);
    }

    // POST /api/email/verification-notification
    public function resend(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        $signedUrl = URL::temporarySignedRoute(
            'api.verification.verify',
            now()->addMinutes(60),
            ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
        );

        $queryString   = parse_url($signedUrl, PHP_URL_QUERY);
        $frontendBase  = rtrim(config('app.frontend_url', env('APP_FRONTEND_URL', 'http://localhost:3000')), '/');
        $frontendLink  = $frontendBase . '/verify-email' . ($queryString ? ('?' . $queryString) : '');

        DB::afterCommit(function () use ($user, $frontendLink) {
            Mail::to($user->email)->queue(new VerifyEmailLink($user, $frontendLink));
        });

        return response()->json(['message' => 'Verification link resent.'], 200);
    }
}
