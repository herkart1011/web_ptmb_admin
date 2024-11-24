<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'name', 'username', 'password',
    ];

    public function isAdmin()
    {
        return $this->user_id === 1;
    }

    public function getRole()
    {
        return $this->isAdmin() ? 'Admin' : 'User';
    }
}

