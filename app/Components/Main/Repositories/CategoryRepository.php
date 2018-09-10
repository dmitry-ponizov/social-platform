<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Statement;
use App\Components\Main\Models\Category;
use Illuminate\Support\Facades\Lang;
use App\Components\Admin\Models\Rule;


class CategoryRepository extends BaseRepository
{

	protected $statement_model;
	protected $model;
	protected $rule_model;

	public function __construct(Statement $statement, Category $model, Rule $rule)
	{
		$this->model = $model;
		$this->statement_model = $statement;
		$this->rule_model = $rule;
	}

	public function getCategories()
	{
		$user_permissions = $this->userPermissions();

		$fields = [
			'edit_rules_category' => [
				'th_name' => Lang::get('main.rule.rules'),
				'name' => Lang::get('main.rule.view'),
				'route' => 'category.edit.rules',
				'button' => 'btn-secondary',

			],
			'edit_category_statement' => [
				'th_name' => Lang::get('main.global.statements'),
				'name' => Lang::get('main.global.view'),
				'route' => 'category.view.statements',
				'button' => 'btn-secondary',

			],

			'edit_category' => [
				'th_name' => Lang::get('main.global.edit'),
				'name' => Lang::get('main.global.edit'),
				'route' => 'category.edit',
				'button' => 'btn-dark',

			],
			'delete_category' => [
				'th_name' => Lang::get('main.global.delete'),
				'name' => Lang::get('main.global.delete'),
				'route' => 'category.delete',
				'button' => 'btn-danger',

			]
		];

		$fields = array_intersect_key($fields, $user_permissions);

		$categories = $this->model->where('parent_id', 0)->orderBy('id')->get();

		$result = $this->toFromat($categories);

		$answer['fields'] = $fields;
		$answer['categories'] = $result;

		return $answer;
	}

	public function saveCategory($id, $request)
	{
		$role = parent::getById($id);

		$role->name = $request->name;

		$role->lang = json_encode($request->lang);

		$role->save();

		return 'ok';
	}

	public function getStatements($category, $id)
	{
		$user_permissions = $this->userPermissions();

		$fields = [
			'view_statement' => [
				'th_name' => Lang::get('main.global.view'),
				'name' => Lang::get('main.global.detail'),
				'route' => 'statement.show',
				'button' => 'btn-secondary',

			],

			'edit_statement' => [
				'th_name' => Lang::get('main.global.edit'),
				'name' => Lang::get('main.global.edit'),
				'route' => 'statement.edit',
				'button' => 'btn-dark',

			],
			'delete_statement' => [
				'th_name' => Lang::get('main.global.delete'),
				'name' => Lang::get('main.global.delete'),
				'route' => 'statement.delete',
				'button' => 'btn-danger',

			]
		];

		$fields = array_intersect_key($fields, $user_permissions);

		$statements = $this->statement_model->with('user')->where('category_id', $id)->get();

		$locale = \App::getLocale();

		$result = [];
		$category_title = '';

		foreach ($statements as $field => $data) {
			$lang = json_decode($category->lang);
			$result[] = [
				'id' => $data->id,
				'title' => $data->title,
				'user' => $data->user->name,
				'category' => $lang->$locale
			];
			$category_title = $lang->$locale;
		}

		$answer['fields'] = $fields;
		$answer['statements'] = $result;
		$answer['category'] = $category_title;


		return $answer;
	}

	public function getRules()
	{
		return $this->rule_model->all();
	}

	public function checkUserCategory($category)
	{

		$rules = $category->rules;

		$statements_users = $this->statement_model->where('category_id', $category->id)->with(['user' => function ($query) {
			$query->with(['profiles' => function ($query) {
				$query->where('accepted', 1);
			}]);
		}])->get();

		$cat_rules = [];

		foreach ($rules as $rule) {
			$cat_rules [$category->id][] = $rule->id;
		}


		$accepted_users_rules = [];


		foreach ($statements_users as $statement) {

			foreach ($statement->user->profiles as $profile) {
				$accepted_users_rules[$statement->user->id][] = $profile->rule_id;
			}
		}


		$user_ids = array_keys($accepted_users_rules);


		$accepted_user_cat = [];

		foreach ($accepted_users_rules as $user_id => $rules) {
			$result = array_diff($cat_rules[$category->id], $rules);

			if (!$result) {
				$accepted_user_cat[] = $user_id;
			}
		}

		$category->users()->detach($user_ids);

		$category->users()->attach($accepted_user_cat);

		return true;
	}

	public function getStatementsCategory($request)
	{
		$cat_id = $request->category_id;

		$statements = $this->statement_model
			->where([
				['category_id', $cat_id],
				['status', 'sent']
			])
			->whereNotNull('sum')
			->orWhere('status', 'accepted')
			->get();

		$result = [];

		foreach ($statements as $statement) {
			$result[$statement->id] = [
				'id' => $statement->id,
				'title' => $statement->title,
				'sum' => $statement->sum,
				'raised' => $statement->raised
			];
		}

		if ($statements) {
			return $result;
		} else {
			return 'error';
		}

	}

	public function getAllCategories()
	{
		$categories = $this->model
			->where([
				['parent_id', 0 ]
			])
			->with('children')
			->select('name', 'id', 'lang')->get();

		$locale = \App::getlocale();

		$result = [];

		foreach ($categories as $category) {
			$lang = json_decode($category->lang);

			$result[$category->id] = [
				'id' => $category->id,
				'name' => $category->name,
				'lang' => $lang->$locale
			];
			foreach ($category->children as $child) {
				$child_lang = json_decode($child->lang);
				$result[$category->id]['children'][] = [
					'id' => $child->id,
					'name' => $child->name,
					'lang' => $child_lang->$locale,
					'publish' => $child->publish
				];
			}


		}
		return $result;
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

	public function publish($id, $status)
	{
		return $this->model->where('id', $id)->update(['publish' => $status]);
	}


}