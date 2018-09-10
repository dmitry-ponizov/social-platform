<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Main\Repositories\SettingsRepository;
use Session;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(SettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $pages = $this->repository->getPages();

        return view('admin.settings.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function elements($slug)
    {
        $elements = $this->repository->getElements($slug);

        return view('admin.settings.pages.elements', compact('elements'));
    }

    public function getContent($slug)
    {

        $contents = $this->repository->getContent($slug);

        return view('admin.settings.pages.contents', compact('contents'));

    }


    public function stateShow($elem, $mod)
    {

        $elements = [
            'left',
            'right',
            'main',
            'main',
            'one',
            'two',
            'three',
            'four',
            'company',
            'news',
            'userful_links',
            'contact',
            'bottom',
            'wrap',
            'statement',
            'volunteers',
	        'partners'
        ];

        if (in_array($mod, $elements)) {

            $answer = $this->repository->showState($elem, $mod);

            if ($answer) {

                Session::flash('success', 'State changed!');

                return redirect()->back();
            }
        } else {
            return redirect()->route('pages');
        }
    }

    public function stateHide($elem, $mod)
    {

        $elements = [
            'left',
            'right',
            'main',
            'main',
            'one',
            'two',
            'three',
            'four',
            'company',
            'news',
            'userful_links',
            'contact',
            'bottom',
            'wrap',
            'statement',
            'volunteers',
	        'partners'
        ];

        if (in_array($mod, $elements)) {

            $answer = $this->repository->hideState($elem, $mod);

            if ($answer) {

                Session::flash('success', 'State changed!');

                return redirect()->back();
            }

        } else {
            return redirect()->route('pages');
        }
    }


    public function edit($elem, $mod)
    {

        $elements = [
            'left',
            'right',
            'main',
            'main',
            'one',
            'two',
            'three',
            'four',
            'company',
            'news',
            'userful_links',
            'contact',
            'bottom',
            'wrap',
            'statement',
            'volunteers',
	        'partners'
        ];

        $one_view = ['actions_block', 'statistics'];

        if (in_array($mod, $elements)) {

            $mod_old = $mod;

            $fields = $this->repository->editElement($elem, $mod);

            if (in_array($elem, $one_view)) {

                $mod = 'index';

            }

            $data = [
                'fields' => $fields,
                'mod' => $mod_old
            ];

            return view('admin.settings.pages.elements.' . $elem . '.' . $mod, $data);

        } else {
            return redirect()->route('pages');
        }


    }

}
