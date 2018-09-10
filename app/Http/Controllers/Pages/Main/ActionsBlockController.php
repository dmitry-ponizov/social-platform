<?php

namespace App\Http\Controllers;

use App\Components\Main\Repositories\ActionsBlockRepository;

use Illuminate\Http\Request;

use Session;

class ActionsBlockController extends Controller
{

    protected $repository;

    public function __construct(ActionsBlockRepository $repository)
    {
        $this->repository = $repository;
    }


    public function update(Request $request,$mod)
    {

   
        $result = $this->repository->updateActions($request,$mod);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','actions_block');
        }
    }


}
