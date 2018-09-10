<?php

namespace App\Http\Controllers;

use App\Components\Main\Repositories\BannerRepository;

use Illuminate\Http\Request;

use Session;

class BannerController extends Controller
{

    protected $repository;

    public function __construct(BannerRepository $repository)
    {
        $this->repository = $repository;
    }


    public function updateLeft(Request $request)
    {

        $result = $this->repository->updateLeftBanner($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','banner_main');
        }
    }

    public function updateRight(Request $request)
    {

        $result = $this->repository->updateRightBanner($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','banner_main');
        }
    }
}
