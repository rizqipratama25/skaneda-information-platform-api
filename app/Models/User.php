<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'role_id',
        'status_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role_id'           => 'integer',
            'status_id'         => 'integer',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function scopeActive($query)
    {
        return $query->whereHas('status', fn($q) => $q->where('name', 'Active'));
    }


    public function sendPasswordResetNotification($token): void
    {
        $frontend = rtrim(config('app.frontend_url', env('APP_FRONTEND_URL', 'http://localhost:3000')), '/');
        $url = $frontend . "/reset-password?token={$token}&email={$this->email}";

        $this->notify(new class($url) extends ResetPasswordNotification {
            public function __construct(public string $resetUrl) {}
            public function toMail($notifiable)
            {
                return (new MailMessage)
                    ->subject('Reset Password')
                    ->line('Klik tombol di bawah untuk mereset password Anda.')
                    ->action('Reset Password', $this->resetUrl)
                    ->line('Jika Anda tidak meminta reset, abaikan email ini.');
            }
        });
    }
}
