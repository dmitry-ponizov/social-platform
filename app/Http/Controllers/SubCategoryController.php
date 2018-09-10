<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Components\Main\Repositories\SubCategoryRepository as Repository;
use Session;

class SubCategoryController extends Controller
{

	public function index($slug, Repository $repository)
	{
		$category = $repository->getSubCategories($slug);

		return view('admin.categories.subcategories', compact('category'));
	}

	public function create($slug)
	{
		return view('admin.categories.create_subcategory', compact('slug'));
	}

	public function store($category_slug, StoreSubcategoryRequest $request, Repository $repository)
	{
		$result = $repository->createSubCategory($category_slug,  str_slug($request->name, '_'),  json_encode($request->lang));

		if(!$result) {
			Session::flash('error', 'Subcategory not created!');
		} else {
			Session::flash('success', 'Subcategory created successfully!');
		}
		return redirect()->route('subcategories', $category_slug);
	}

	public function edit($slug, Repository $repository)
	{
		$subcategory  = $repository->getSubcategory($slug);

		$categories = $repository->getParentCategories();

		return view('admin.categories.edit_subcategory', [
			'subcategory' => $subcategory,
			'categories' => $categories
		]);
	}
	public function update($slug_subcat, UpdateSubcategoryRequest $request, Repository $repository)
	{
		$result = $repository->updateSubcategory($slug_subcat, $request->parent_id, $request->lang, $request->name);

		if(!$result) {
			Session::flash('error', 'Subcategory not updated!');
		} else {
			Session::flash('success', 'Subcategory update successfully!');
		}
		return redirect()->route('categories');
	}
}
