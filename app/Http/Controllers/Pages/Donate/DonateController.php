<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Main\Repositories\DonateRepository;
use Session;

class DonateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(DonateRepository $donate)
    {
        $this->repository = $donate;
    }

    public function index($uuid = null)
    {

        if($uuid){
            $statement = $this->repository->getStatement($uuid);
        }

        $statements = $this->repository->getStatements();

        $settings = $this->repository->getSettings();

        $categories = $this->repository->getCategories();

        $lang = \Lang::get('main.main.donation');

        $data = [
            'categories'=>$categories,
            'statements'=>$statements,
            'statement'=>(isset($statement)? $statement : ''),
            'settings'=>$settings,
            'lang'=>$lang
        ];

        return view('main.pages.donate',$data);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'heading'=>'required|max:255'
        ]);
        $result = $this->repository->updateSettings($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','quick_donate');
        }
    }
}
