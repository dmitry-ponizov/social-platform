<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use parseCSV;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function upload()
    {


//        $csv = new parseCSV();
//
//        $csv->encoding('windows-1251', 'UTF-8');
//        $csv->delimiter = ";";
//
//
//        $csv->fields = ['region', 'area', 'city', 'index', 'street', 'houses'];
//        $csv->parse('storage/houses/houses.csv');
//        $res =[];
//        foreach ($csv->data as $key => $row) {
//             unset($row['index']);
//             unset($row['houses']);
//             $res[$row['region']][$row['area']][$row['city']][]=$row['street'];
//        }


        $file = './storage/houses/result.json';

//        $encode = json_encode($res,true);

//        file_put_contents($file,$encode);


        $file_get = file_get_contents($file);

        $decode = json_decode($file_get,true);

        $regions= array_keys($decode);

//        dd($regions);



    }
}
