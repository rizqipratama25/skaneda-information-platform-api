<!DOCTYPE html>
<html>
<body>
  <p>Hi {{ $user->fullname ?? $user->email }},</p>
  <p>Click the button below to verify your email (valid for 60 minutes):</p>
  <p><a href="{{ $verifyUrl }}" style="padding:10px 16px;background:#2d6cdf;color:#fff;text-decoration:none;border-radius:6px;">Verify Email</a></p>
  <p>If you didn’t create an account, please ignore this email.</p>
</body>
</html>
