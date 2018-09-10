<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Category;

class SubCategoryRepository extends BaseRepository
{


	protected $model;


	public function __construct(Category $model)
	{
		$this->model = $model;

	}

	public function getSubCategories($slug)
	{

		$category = $this->model->where('name', $slug)->with('children')->orderBy('id')->first();

		$transform_data = $this->transformCategory($category);

		return $transform_data;
	}

	/**
	 * @param $category
	 * @return array
	 */
	protected function transformCategory($category): array
	{
		$transform_data = [];

		$locale = \App::getLocale();

		$lang = json_decode($category->lang);


		$transform_data['parent'] = [
			'id' => $category->id,
			'lang' => $lang->$locale,
			'name' => $category->name
		];

		foreach ($category->children as $child) {
			$child_lang = json_decode($child->lang);

			$transform_data['children'][] = [
				'id' => $child->id,
				'name' => $child->name,
				'lang' => $child_lang->$locale,
				'publish' => $child->publish
			];

		}

		return $transform_data;
	}

	public function createSubCategory($category_slug, $name, $lang)
	{
		try {
			$category = $this->model->where('name', $category_slug)->first();

			$this->model->create([
				'name' => $name,
				'lang' => $lang,
				'parent_id' => $category->id
			]);

			return true;

		} catch (\Exception $e) {
			return false;
		}
	}

	public function getSubcategory($slug)
	{
		$subcat = $this->model->where('name', $slug)->with('parent')->first();

		$locale = \App::getLocale();

		$lang = json_decode($subcat->lang);

		return [
			'id' => $subcat->id,
			'slug' => $subcat->name,
			'lang' => $lang,
			'name' => $lang->$locale,
			'parent_slug' => $subcat->parent->name
		];
	}

	public function getParentCategories()
	{
		return $this->toFromat($this->model->where('parent_id', 0)->get());
	}

	public function updateSubcategory($slug, $parent_id, $lang ,$name)
	{
		try {
			$this->model->where('name', $slug)->update([
				'name' => $name,
				'lang' => json_encode($lang),
				'parent_id' => $parent_id
			]);

			return true;

		} catch (\Exception $e) {
			return false;
		}
	}
	protected function toFromat($categories): array
	{
		$locale = \App::getLocale();

		$result = [];

		foreach ($categories as $field => $data) {
			$lang = json_decode($data->lang);
			$result[] = [
				'id' => $data->id,
				'slug' => $data->name,
				'name' => $lang->$locale,
				'publish' => $data->publish
			];
		}
		return $result;
	}
}