<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // This Link --> http://novate.co.uk/changing-the-laravel-5-3-password-reset-email-text/
     /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
         $this->notify(new MailResetPasswordToken($token));
    }
}
