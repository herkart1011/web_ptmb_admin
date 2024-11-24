<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', // Kolom name
        'username', // Kolom username
        'pswd', // Kolom pswd (password)
    ];

    /**
     * Set password.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['pswd'] = bcrypt($value);
    }
}
