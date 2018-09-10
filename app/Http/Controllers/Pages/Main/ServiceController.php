<?php

namespace App\Http\Controllers;

use App\Components\Main\Repositories\ServiceRepository;

use Illuminate\Http\Request;

use Session;

class ServiceController extends Controller
{

    protected $repository;

    public function __construct(ServiceRepository $repository)
    {
        $this->repository = $repository;
    }


    public function update(Request $request)
    {
        $this->validate($request,[
            'count_slides'=>'required|integer|max:4'
        ]);
   
        $result = $this->repository->updateService($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','service');
        }
    }


}
