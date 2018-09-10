<?php

namespace App\Http\Controllers;

use App\Components\Main\Models\Statement;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use App\Components\Main\Repositories\MainRepository;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MainController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected $repository;

	public function __construct(MainRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index()
	{

		$sliders = $this->repository->getSliders();

		$last_statements = $this->repository->getNotSumStatements();

		$finance_statements = $this->repository->getFinanceStatements();

		$categories = $this->repository->getCategories();

		$volunteers = $this->repository->getVolunteers();

		$partners = $this->repository->getPartners();

		$lang = Lang::get('main.main');

		$data = [
			'sliders' => $sliders,
			'last_statements' => $last_statements,
			'finance_statements' => $finance_statements,
			'volunteers' => $volunteers,
			'lang' => $lang,
			'categories' => $categories,
			'partners' => $partners,
		];
		return view('index', $data);

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
	public function edit($id)
	{
		//
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


	public function areas(Request $request)
	{
		$region = $request->input('region');

		$file = 'uploads/defaults/address/location.json';

		$file_get = file_get_contents($file);

		$decode = json_decode($file_get, true);

		return array_keys($decode[$region]);

	}

	public function cities(Request $request)
	{
		$region = $request->input('region');

		$area = $request->input('area');

		$file = 'uploads/defaults/address/location.json';

		$file_get = file_get_contents($file);

		$decode = json_decode($file_get, true);

		return array_keys($decode[$region][$area]);

	}

	public function streets(Request $request)
	{
		$region = $request->input('region');

		$area = $request->input('area');

		$city = $request->input('city');

		$file = 'uploads/defaults/address/location.json';

		$file_get = file_get_contents($file);

		$decode = json_decode($file_get, true);

		$streets = $decode[$region][$area][$city];

		$streets = array_unique($streets);

		setlocale(LC_ALL, 'uk_UA.utf8');

		sort($streets, SORT_LOCALE_STRING);

		return $streets;

	}

	public function becomeVolunteer(Request $request, Recaptcha $recaptcha)
	{
		$this->validate($request, [
			'name' => 'required|max:60',
			'gender' => 'required|in:male,female,not_specified',
			'mobile_phone' => 'required',
			'email' => 'required|email',
			'message' => 'max:255'
		]);

		$result = $this->repository->storeVolunteerStatement($request);

		return $result ? response('ok', 200) : abort(403, \Lang::get('main.main.volunteers.already_accept'));

	}
}
