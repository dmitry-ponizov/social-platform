<?php

namespace App\Http\Controllers;

use App\Components\Main\Repositories\FinanceRepository;

use Illuminate\Http\Request;

use Session;

class FinanceController extends Controller
{

    protected $repository;

    public function __construct(FinanceRepository $repository)
    {
        $this->repository = $repository;
    }


    public function update(Request $request)
    {
        $result = $this->repository->updateFinance($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','finance');
        }
    }

    public function updateStatement(Request $request)
    {
        $this->validate($request,[
            'count_slides'=>'required|integer|max:3'
        ]);
        $result = $this->repository->updateStatement($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','finance');
        }
    }


}
