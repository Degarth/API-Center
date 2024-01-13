<?php

namespace App\Services;

use App\Models\User;

class SocialService
{
    protected $user;

    public function __construct()
    {
        $this->user = User::factory()->make();
    }

    public function getAllData()
    {
        return $this->user;
    }

    public function getName()
    {
        return $this->user->name;
    }

    public function getEmail()
    {
        return $this->user->email;
    }

}
