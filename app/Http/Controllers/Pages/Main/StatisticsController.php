<?php

namespace App\Http\Controllers;

use App\Components\Main\Repositories\StatisticsRepository;

use Illuminate\Http\Request;

use Session;

class StatisticsController extends Controller
{

    protected $repository;

    public function __construct(StatisticsRepository $repository)
    {
        $this->repository = $repository;
    }


    public function update(Request $request,$mod)
    {

   
        $result = $this->repository->updateStatistics($request,$mod);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','statistics');
        }
    }


}
