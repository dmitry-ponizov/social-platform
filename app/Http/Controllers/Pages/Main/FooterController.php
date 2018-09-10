<?php

namespace App\Http\Controllers;

use App\Components\Main\Repositories\FooterRepository;

use Illuminate\Http\Request;

use Session;

class FooterController extends Controller
{

    protected $repository;

    public function __construct(FooterRepository $repository)
    {
        $this->repository = $repository;
    }


    public function updateCompany(Request $request)
    {
        $result = $this->repository->updateCompany($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','footer');
        }
    }
    public function updateNews(Request $request)
    {
        $result = $this->repository->updateNews($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','footer');
        }
    }

    public function updateLinks(Request $request)
    {
        $result = $this->repository->updateLinks($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','footer');
        }
    }
    public function updateContacts(Request $request)
    {
        $result = $this->repository->updateContacts($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','footer');
        }
    }
    public function updateBottom(Request $request)
    {
        $result = $this->repository->updateBottom($request);

        if($result){

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content','footer');
        }
    }


}
