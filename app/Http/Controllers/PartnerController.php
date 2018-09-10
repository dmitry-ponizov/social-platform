<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePartnerRequest;
use App\Components\Admin\Repositories\PartnerRepository as Repository;

use App\Http\Requests\UpdatePartnerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class PartnerController extends Controller
{
	/**
	 * @param Repository $repository
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Repository $repository)
	{
		$partners = $repository->getAllPartners();

		return view('admin.partners.index', compact('partners'));
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
	{
		return view('admin.partners.create');
	}

	/**
	 * @param CreatePartnerRequest $request
	 * @param Repository $repository
	 * @return \Illuminate\Http\JsonResponse|void
	 */
	public function store(CreatePartnerRequest $request, Repository $repository)
	{
		$result = $repository->store($request->name, $request->url, $request->file('photo'), $request->about);

		return $result ? response()->json($result) : abort(400, 'Partner was not created!');
	}

	/**
	 * @param $slug
	 * @param Repository $repository
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function show($slug, Repository $repository)
	{
		$partner = $repository->getBySlug($slug);

		return $partner ? view('admin.partners.show', compact('partner')) :  redirect()->back();

	}

	/**
	 * @param $slug
	 * @param Repository $repository
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function publish($slug, Repository $repository)
	{
		$result = $repository->publish($slug);

		if(!$result)  Session::flash('error', 'Partner not changed!');

		return  redirect()->back();
	}

	/**
	 * @param $slug
	 * @param Repository $repository
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function edit($slug, Repository $repository)
	{
		$partner = $repository->getBySlug($slug);

		return $partner ? view('admin.partners.edit', compact('partner')) :  redirect()->back();

	}

	/**
	 * @param $slug
	 * @param UpdatePartnerRequest $request
	 * @param Repository $repository
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update($slug, UpdatePartnerRequest $request, Repository $repository)
	{
		$result = $repository->updatePartner($slug, $request);

		if(!$result) Session::flash('error', 'Partner not updated!');

		return  redirect()->route('partners');
	}

	/**
	 * @param $slug
	 * @param Repository $repository
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete($slug, Repository $repository)
	{
		$result = $repository->delete($slug);

		if(!$result) Session::flash('error', 'Partner not deleted!');

		return  redirect()->route('partners');
	}

	/**
	 * @param Request $request
	 * @param Repository $repository
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateSettings(Request $request, Repository $repository)
	{
		$result = $repository->updatePartnersBlock($request);

		if ($result) Session::flash('success', 'Element updated!');

		return redirect()->route('element.content', 'partners');

	}

	/**
	 * @param Request $request
	 * @param Repository $repository
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateCountSlidesSettings(Request $request, Repository $repository)
	{
		$result = $repository->updateCount($request);

		if ($result) Session::flash('success', 'Element updated!');

		return redirect()->route('element.content', 'partners');

	}
}
