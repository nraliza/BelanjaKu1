<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class DummyUser implements JWTSubject
{
    public $id;
    public $name;
    public $email;
    public $role;

    public function __construct($attributes)
    {
        $this->id = $attributes['id'] ?? null;
        $this->name = $attributes['name'] ?? null;
        $this->email = $attributes['email'] ?? null;
        $this->role = $attributes['role'] ?? 'user';
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
