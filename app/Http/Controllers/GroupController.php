<?php

namespace App\Http\Controllers;

use App\Components\Admin\Repositories\GroupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;

    public function __construct(GroupRepository $rule)
    {
        $this->repository = $rule;
    }

    public function index()
    {

        $data = $this->repository->getGroups();

        return view('admin.groups.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.groups.create');
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
            'label' => 'required|max:32',
            'lang.ru' => 'required',
            'lang.ua' => 'required',
            'lang.en' => 'required',
        ]);

        $group_attr = ['label' => $request->label, 'parent_id' => 0, 'slug' => str_slug($request->label, '_'), 'lang' => json_encode($request->lang)];

        $this->repository->insert($group_attr);

        Session::flash('success', 'Group create successfully.');

        return redirect()->route('groups');

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
        $group = $this->repository->getById($id);

        $locale = \App::getLocale();

        $group->lang = json_decode($group->lang);

        $group->locale = $group->lang->$locale;

        return view('admin.groups.edit_group', compact('group'));
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
            'label' => 'required|max:255',
            'lang.ru' => 'required',
            'lang.ua' => 'required',
            'lang.en' => 'required',
        ]);

        $this->repository->updateGroup($id, $request);


        Session::flash('success', 'Group updated successfully.');

        return redirect()->route('groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        Session::flash('success', 'Group deleted successfully.');

        return redirect()->back();
    }

    public function showSubgroups($id)
    {
        $data = $this->repository->getSubgroups($id);


        return view('admin.groups.subgroups', compact('data'));
    }


    public function editSubgroups($id)
    {

        $answer = $this->repository->editSubgroup($id);

        $data = [
            'subgroup' => $answer['subgroup'],
            'parent_groups' => $answer['parent_groups']
        ];

        return view('admin.groups.edit_subgroups', $data);
    }

    public function editRules($id)
    {
        $data = $this->repository->getRules($id);

        return view('admin.groups.rules', compact('data'));
    }

    public function rulesGroupsUpdate(Request $request)
    {

        $result = $this->repository->updateRulesGroups($request);

        if ($result) {

            Session::flash('success', 'Rules updated successfully.');

            return redirect()->back();
        }
    }

    public function subgroupUpdate(Request $request, $id)
    {

        $this->validate($request, [
            'label' => 'required|max:32',
            'parent' => 'required|max:32',
            'lang.ru' => 'required',
            'lang.ua' => 'required',
            'lang.en' => 'required',
        ]);

        $response = $this->repository->updateSubgroup($request, $id);


        if ($response) {
            Session::flash('success', 'Subgroup updated successfully.');

            return redirect()->route('groups');
        }
    }

    public function createSubgroup($id)
    {

        $parent_groups = $this->repository->getParentGroups();

        $data = [
            'parent_groups' => $parent_groups,
            'group_id' => $id
        ];

        return view('admin.groups.create_subgroup', $data);
    }

    public function storeSubgroup(Request $request)
    {

        $this->validate($request, [
            'label' => 'required|max:32',
            'parent' => 'required|max:32',
            'lang.ru' => 'required',
            'lang.ua' => 'required',
            'lang.en' => 'required',
        ]);

        $group_attr = ['label' => $request->label, 'parent_id' => $request->parent, 'slug' => str_slug($request->label, '_'), 'lang' => json_encode($request->lang)];

        $this->repository->insert($group_attr);

        Session::flash('success', 'Subroup create successfully.');

        return redirect()->route('subgroups', $request->parent);

    }
}
