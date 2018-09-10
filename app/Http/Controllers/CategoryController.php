<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use App\Components\Main\Repositories\CategoryRepository;
use Session;

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected $repository;

	public function __construct(CategoryRepository $repository)
	{
		$this->repository = $repository;
	}

	public function index()
	{
		$user_permissions = $this->repository->userPermissions();

		if (in_array('view_category', $user_permissions)) {

			$data = $this->repository->getCategories();

			return view('admin.categories.index', compact('data'));

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

		if (in_array('create_category', $user_permissions)) {

			return view('admin.categories.create');

		} else {
			Session::flash('info', 'No permission!');

			return redirect()->route('admin.main');
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

		if (in_array('create_category', $user_permissions)) {

			$this->validate($request, [
				'name' => 'required|max:255',
				'lang.ru' => 'required',
				'lang.ua' => 'required',
				'lang.en' => 'required',
			]);

			$category_attr = ['name' => str_slug($request->name, '_'), 'lang' => json_encode($request->lang)];

			$this->repository->insert($category_attr);

			Session::flash('success', 'Category create successfully.');

			return redirect()->route('categories');
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
		$user_permissions = $this->repository->userPermissions();

		if (in_array('edit_category', $user_permissions)) {
			$category = $this->repository->getById($id);

			$locale = \App::getlocale();

			$category->lang = json_decode($category->lang);

			$category->locale = $category->lang->$locale;

			return view('admin.categories.edit', compact('category'));

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

		if (in_array('edit_category', $user_permissions)) {

			$this->validate($request, [
				'name' => 'required|max:255',
				'lang.ru' => 'required',
				'lang.ua' => 'required',
				'lang.en' => 'required',
			]);

			$this->repository->saveCategory($id, $request);


			Session::flash('success', 'Category updated successfully.');

			return redirect()->route('categories');

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

		if (in_array('delete_category', $user_permissions)) {

			$this->repository->delete($id);

			Session::flash('success', 'Category deleted successfully.');

			return redirect()->back();

		} else {
			Session::flash('info', 'No permission!');

			return redirect()->route('admin.main');
		}
	}

	public function viewStatements($id)
	{
		$user_permissions = $this->repository->userPermissions();

		if (in_array('edit_category_statement', $user_permissions)) {

			$category = $this->repository->getById($id);

			$data = $this->repository->getStatements($category, $id);

			return view('admin.categories.view_statements', compact('data'));
		} else {
			Session::flash('info', 'No permission!');

			return redirect()->route('admin.main');
		}

	}

	public function editRules($id)
	{
		$user_permissions = $this->repository->userPermissions();

		if (in_array('edit_rules_category', $user_permissions)) {
			$category = $this->repository->getById($id);

			$category->lang = json_decode($category->lang);

			$locale = \App::getLocale();

			$category->lang = $category->lang->$locale;

			$category_rules = $category->rules->toArray();

			$rules = $this->repository->getRules();

			$rules = $rules->toArray();

			foreach ($category_rules as $key => $rule) {
				foreach ($rules as &$value) {
					if ($rule['label'] == $value['label']) {
						$value['checked'] = true;

					}
				}

			}
			foreach ($rules as &$rule) {
				$lang = json_decode($rule['lang'], true);
				$rule['lang'] = $lang[$locale];
			}

			$data = [
				'category' => $category,
				'rules' => $rules
			];

			return view('admin.categories.edit_rules', $data);
		} else {
			Session::flash('info', 'No permission!');

			return redirect()->route('admin.main');
		}
	}

	public function updateRules(Request $request, $id)
	{
		$user_permissions = $this->repository->userPermissions();

		if (in_array('edit_rules_category', $user_permissions)) {

			$category = $this->repository->getById($id);

			$category->rules()->sync($request->rules);

			$check_user_category = $this->repository->checkUserCategory($category);

			if ($check_user_category) {

				Session::flash('success', 'Category rules update');

				return redirect()->route('categories');
			}


		} else {
			Session::flash('info', 'No permission!');

			return redirect()->route('admin.main');
		}
	}

	public function showStatements(Request $request)
	{
		$statements = $this->repository->getStatementsCategory($request);

		return $statements;
	}

	public function getCategories()
	{
		$categories = $this->repository->getAllCategories();

		return ($categories) ? response($categories, 200) : abort(422, 'Error');
	}

	public function publish()
	{
		$request = request();

		$request->validate([
			'id' => 'required|numeric',
			'publish' => 'required|boolean'
		]);

		$result = $this->repository->publish($request->id, $request->publish);

		return $result ? response('ok', 200) : abort(422, 'error');

	}


}
