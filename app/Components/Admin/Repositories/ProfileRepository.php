<?php

namespace App\Components\Admin\Repositories;


use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\Profile;

class ProfileRepository extends BaseRepository
{

    protected $model;


    public function __construct(Profile $profile)
    {
        $this->model = $profile;

    }


}