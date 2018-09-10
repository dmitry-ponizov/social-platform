<?php

namespace App\Http\Controllers;

use App\Components\Admin\Repositories\RuleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Lang;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(RuleRepository $rule)
    {
        $this->repository = $rule;
    }

    public function index()
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_rules_list', $user_permissions)) {

            $data = $this->repository->getRules();

            return view('admin.rules.index', compact('data'));

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

        if (in_array('create_rule', $user_permissions)) {

            $types = Lang::get('main.rule.types');

            $groups = $this->repository->getGroups();

            $data = [
                'types' => $types,
                'groups' => $groups
            ];

            return view('admin.rules.create', $data);

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

        if (in_array('create_rule', $user_permissions)) {

            $this->validate($request, [
                'label' => 'required|max:255',
                'lang.ru' => 'required',
                'lang.ua' => 'required',
                'lang.en' => 'required',
                'type' => 'required',
                'group' => 'required'
            ]);

            $rule_attr = [
                'label' => $request->label,
                'slug' => str_slug($request->label, '_'),
                'type' => $request->type,
                'group_id' => $request->group,
                'lang' => json_encode($request->lang)];

            $this->repository->insert($rule_attr);

            Session::flash('success', 'Rule create successfully.');

            return redirect()->route('rules');
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

        if (in_array('edit_rule', $user_permissions)) {

            $rule = $this->repository->getById($id);

            $locale = \App::getLocale();

            $rule->lang = json_decode($rule->lang);

            $rule->locale = $rule->lang->$locale;

            $types = Lang::get('main.rule.types');

            $groups = $this->repository->getGroups();

            $data = [
                'rule' => $rule,
                'types' => $types,
                'groups' => $groups
            ];
            return view('admin.rules.edit', $data);

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

        if (in_array('edit_rule', $user_permissions)) {

            $this->validate($request, [
                'label' => 'required|max:255',
                'type' => 'required',
                'group' => 'required',
                'lang.ru' => 'required',
                'lang.ua' => 'required',
                'lang.en' => 'required',
            ]);

//            dd($request->all());
            $this->repository->updateRule($id, $request);


            Session::flash('success', 'Rule updated successfully.');

            return redirect()->route('rules');

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

        if (in_array('delete_rule', $user_permissions)) {

            $this->repository->delete($id);

            Session::flash('success', 'Rule deleted successfully.');

            return redirect()->back();

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function editCategories($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_categories_rule', $user_permissions)) {

            $rule = $this->repository->getById($id);

            $rule_categories = $rule->categories->toArray();

            $rule->lang = json_decode($rule->lang);

            $locale = \App::getLocale();

            $rule->lang = $rule->lang->$locale;

            $categories = $this->repository->getCategories();

            $categories = $categories->toArray();

            foreach ($rule_categories as $key => $category) {
                foreach ($categories as &$value) {
                    if ($category['name'] == $value['name']) {
                        $value['checked'] = true;

                    }
                }

            }
            foreach ($categories as &$category) {
                $lang = json_decode($category['lang'], true);
                $category['lang'] = $lang[$locale];
            }

            $data = [
                'rule' => $rule,
                'categories' => $categories
            ];

            return view('admin.rules.edit_categories', $data);

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function updateCategories(Request $request, $id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_categories_rule', $user_permissions)) {

            $rule = $this->repository->getById($id);

            $rule->categories()->sync($request->categories);

            Session::flash('success', 'Rule categories update');

            return redirect()->route('rules');

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }
}
