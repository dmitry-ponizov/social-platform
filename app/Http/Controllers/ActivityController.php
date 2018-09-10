<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Main\Repositories\ActivityRepository;
use Session;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(ActivityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getHistory()
    {
        $history = $this->repository->getHistory();

        return response()->json($history);
    }

    public function getStatistics()
    {
        $result = $this->repository->getStatistic();

        return ($result) ?: abort(422, 'Error');
    }

    public function socialServiceStatistic()
    {
        $result = $this->repository->getSocialStatistic();

        return ($result) ?: abort(422, 'Error');
    }

}
