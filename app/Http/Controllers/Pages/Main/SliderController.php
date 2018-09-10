<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Main\Models\Slider;
use App\Components\Main\Repositories\SliderRepository;
use Session;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(SliderRepository $slider)
    {
        $this->repository = $slider;
    }

    public function index()
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_sliders', $user_permissions)) {

            $data = $this->repository->getSliders();

            return view('admin.settings.sliders_list', compact('data'));

        } else {

            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('create_slider', $user_permissions)) {
            $last_order = $this->repository->lastOrder();

            return view('admin.settings.create_slider', compact('last_order'));

        } else {

            Session::flash('info', 'No permission!');

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('create_slider', $user_permissions)) {
            $this->validate($request, [
                'title.ru' => 'required',
                'title.ua' => 'required',
                'title.en' => 'required',
                'heading.ru' => 'required',
                'heading.ua' => 'required',
                'heading.en' => 'required',
                'description.ru' => 'required',
                'description.ua' => 'required',
                'description.en' => 'required',
                'link_title.ru' => 'required',
                'link_title.ua' => 'required',
                'link_title.en' => 'required',
                'order' => 'required|unique:sliders',
//                'image' => 'required|image|mimes:jpeg,bmp,png|max:5000|dimensions:width=2560,height=400'
            ]);

            $answer = $this->repository->storeSlider($request);

            if ($answer) {
                Session::flash('success', 'Slider created successfully!');
            }

            return redirect()->route('sliders');

        } else {

            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = $this->repository->getSlider($id);

        return view('admin.settings.edit_slider', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title.ru' => 'required',
            'title.ua' => 'required',
            'title.en' => 'required',
            'heading.ru' => 'required',
            'heading.ua' => 'required',
            'heading.en' => 'required',
            'description.ru' => 'required',
            'description.ua' => 'required',
            'description.en' => 'required',
            'link_title.ru' => 'required',
            'link_title.ua' => 'required',
            'link_title.en' => 'required',
//                'image' => 'required|image|mimes:jpeg,bmp,png|max:5000|dimensions:width=2560,height=400'
        ]);


        $status = $this->repository->updateSlider($id, $request);

        if($status){

            Session::flash('success', 'Slider updated successfully.');

            return redirect()->route('sliders');
        }



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
}
