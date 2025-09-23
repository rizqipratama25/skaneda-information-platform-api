<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Verification</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f9f9f9;">

  <!-- Wrapper -->
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="center" style="padding:30px 15px;">
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05);">

          <!-- Header with Logo -->
          <tr>
            <td align="center" style="background:#2d6cdf; padding:20px;">
              <img src="https://smkn2mojokerto.sch.id/assets/images/logo_skaneda.png" alt="Logo Sekolah" width="160" height="80" style="display:block; margin-bottom:10px;">
              <h2 style="color:#ffffff; margin:0; font-size:20px;">SMK Negeri 2 Kota Mojokerto</h2>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:30px; color:#333333; font-size:15px; line-height:1.6;">
              <p>Hi <strong>{{ $user->fullname ?? $user->email }}</strong>,</p>
              <p>Terima kasih telah mendaftar. Untuk melanjutkan, silakan verifikasi alamat email Anda dengan menekan tombol di bawah ini. Link ini hanya berlaku selama <strong>60 menit</strong>:</p>

              <p style="text-align:center; margin:30px 0;">
                <a href="{{ $verifyUrl }}" style="padding:12px 24px; background:#2d6cdf; color:#ffffff; text-decoration:none; border-radius:6px; font-weight:bold; font-size:16px;">
                  Verifikasi Email
                </a>
              </p>

              <p>Jika Anda tidak membuat akun, abaikan email ini.</p>
              <p>Salam hangat,<br>Tim SMK Negeri 2 Kota Mojokerto</p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td align="center" style="background:#f1f1f1; padding:15px; font-size:12px; color:#666;">
              &copy; {{ date('Y') }} SMK Negeri 2 Kota Mojokerto.
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
