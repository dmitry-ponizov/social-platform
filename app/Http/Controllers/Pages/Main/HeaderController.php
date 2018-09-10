<?php

namespace App\Http\Controllers;

use App\Components\Main\Repositories\HeaderRepository;

use Illuminate\Http\Request;

use Session;

class HeaderController extends Controller
{

    protected $repository;

    public function __construct(HeaderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(Request $request)
    {
        $result =  $this->repository->updateHeader($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','header');
        }
    }

}
