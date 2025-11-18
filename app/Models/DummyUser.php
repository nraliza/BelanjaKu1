<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class DummyUser implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    public $id;
    public $name;
    public $email;
    public $role;

    public function __construct($attributes)
    {
        $this->id    = $attributes['id'] ?? null;
        $this->name  = $attributes['name'] ?? null;
        $this->email = $attributes['email'] ?? null;
        $this->role  = $attributes['role'] ?? 'user';
    }

    public function getJWTIdentifier()
    {
        return $this->email;
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
