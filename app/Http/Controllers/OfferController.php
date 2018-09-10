<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Components\Main\Repositories\OfferRepository;
use Illuminate\Support\Facades\Lang;
use Session;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(OfferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_offers_list', $user_permissions)) {

            $data = $this->repository->getOffers();

            return view('admin.offers.index', compact('data'));

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
        $file = 'uploads/defaults/address/location.json';

        $categories = $this->repository->getCategories();

        $file_get = file_get_contents($file);

        $decode = json_decode($file_get, true);

        $regions = array_keys($decode);

        $lang = Lang::get('main.offer');

        $answer = [
            'categories' => $categories,
            'regions' => $regions,
            'lang' => $lang
        ];

        $data = [
            'answer' => $answer,
        ];


        return view('main.offers.create', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'region' => 'required',
            'area' => 'required',
            'city' => 'required',
            'street' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $answer = $this->repository->storeOffer($request);

        if ($answer) {
            Session::flash('success', 'Offer created successful!');
        }

        return response('ok', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_offer', $user_permissions)) {

            $offer = $this->repository->getRelations($id);

            return view('admin.offers.show', compact('offer'));


        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_offer', $user_permissions)) {

            $offer = $this->repository->getRelations($id);

            $users = $this->repository->getUsers();

            $categories = $this->repository->getCategories();

            $data = [
                'offer' => $offer,
                'users' => $users,
                'categories' => $categories
            ];

            return view('admin.offers.edit', $data);

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }

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
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_offer', $user_permissions)) {
            $this->validate($request, [
                'title' => 'required|max:32',
                'user_id' => 'required',
                'description' => 'required',
                'image' => 'mimes:jpeg,bmp,png|file|max:10000'
            ]);

            $answer = $this->repository->updateOffer($request, $id);

            if ($answer) {
                Session::flash('success', 'Offer update successfully.');
            }


            return redirect()->route('offers');

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
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
        $user_permissions = $this->repository->userPermissions();

        if (in_array('delete_offer', $user_permissions)) {

            $offer = $this->repository->getById($id);

            $offer->delete();

            Session::flash('success', 'Offer deleted successfully.');

            return redirect()->route('offers');

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function noPublish($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('publish_offer', $user_permissions)) {
            $this->repository->noPublished($id);

            Session::flash('success', 'Statement no published.');

            return redirect()->back();
        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }


    public function publish($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('publish_offer', $user_permissions)) {

            $this->repository->published($id);

            Session::flash('success', 'Statement published successfully.');

            return redirect()->back();
        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }
}
