<?php

namespace App\Http\Controllers;

use App\Components\Main\Repositories\WelcomeBlockRepository;

use Illuminate\Http\Request;

use Session;

class WelcomeBlockController extends Controller
{

    protected $repository;

    public function __construct(WelcomeBlockRepository $repository)
    {
        $this->repository = $repository;
    }


    public function update(Request $request)
    {

        $result = $this->repository->updateWelcome($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','welcome_block');
        }
    }


}
