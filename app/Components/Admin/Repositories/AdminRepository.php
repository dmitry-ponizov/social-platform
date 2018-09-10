<?php

namespace App\Components\Admin\Repositories;


use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\User;

class AdminRepository extends BaseRepository
{

    protected $user_model;

    public function __construct(User $user)
    {
        $this->user_model = $user;

    }
}