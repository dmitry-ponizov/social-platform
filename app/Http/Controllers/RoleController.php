<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Admin\Repositories\RoleRepository;
use Illuminate\Support\Facades\Session;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;


    public function __construct(RoleRepository $role)
    {
        $this->repository = $role;
    }

    public function index()
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_role', $user_permissions)) {

            $data = $this->repository->getRoles();

            return view('admin.roles.index', compact('data'));

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

        if (in_array('create_role', $user_permissions)) {

            return view('admin.roles.create');

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

        if (in_array('create_role', $user_permissions)) {

            $this->validate($request, [
                'name' => 'required|max:255',
                'lang.ru' => 'required',
                'lang.ua' => 'required',
                'lang.en' => 'required',
            ]);

            $role_attr = ['name' => $request->name, 'lang' => json_encode($request->lang)];

            $this->repository->insert($role_attr);

            Session::flash('success', 'Role create successfully.');

            return redirect()->route('roles');
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

        if (in_array('edit_role', $user_permissions)) {

            $role = $this->repository->getById($id);

            $locale = \App::getLocale();

            $role->lang = json_decode($role->lang);

            $role->locale = $role->lang->$locale;

            return view('admin.roles.edit', compact('role'));

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

        if (in_array('edit_role', $user_permissions)) {

            $this->validate($request, [
                'name' => 'required|max:255',
                'lang.ru' => 'required',
                'lang.ua' => 'required',
                'lang.en' => 'required',
            ]);

            $this->repository->saveRole($id, $request);


            Session::flash('success', 'Role updated successfully.');

            return redirect()->route('roles');

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

        if (in_array('delete_role', $user_permissions)) {

            $this->repository->delete($id);

            Session::flash('success', 'Role deleted successfully.');

            return redirect()->back();

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function editUsers($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_role_users', $user_permissions)) {

            $role = $this->repository->getById($id);

            $locale = \App::getLocale();

            $role->lang = json_decode($role->lang);

            $role->lang = $role->lang->$locale;

            $role_users = $role->users->toArray();

            $users = $this->repository->getUsers();

            $users = $users->toArray();

            foreach ($role_users as $key => $user) {
                foreach ($users as &$value) {
                    if ($user['name'] == $value['name']) {
                        $value['checked'] = true;
                    }
                }

            }

            $data = [
                'role' => $role,
                'users' => $users
            ];

            return view('admin.roles.edit_users', $data);

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }


    public function updateUsers(Request $request, $id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_role_users', $user_permissions)) {

            $role = $this->repository->getById($id);

            $role->users()->sync($request->users);

            Session::flash('success', 'Role users update');

            return redirect()->route('roles');
        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function editPermissions($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_role_permissions', $user_permissions)) {

            $role = $this->repository->getById($id);

            $role_permissions = $role->permissions->toArray();

            $role->lang = json_decode($role->lang);

            $locale = \App::getLocale();

            $role->lang = $role->lang->$locale;

            $permissions = $this->repository->getPermissions();

            $permissions = $permissions->toArray();

            foreach ($role_permissions as $key => $permission) {
                foreach ($permissions as &$value) {
                    if ($permission['slug'] == $value['slug']) {
                        $value['checked'] = true;
                    }
                }

            }

            foreach ($permissions as &$permission) {
                $lang = json_decode($permission['lang'], true);
                $permission['lang'] = $lang[$locale];
            }

            $data = [
                'role' => $role,
                'permissions' => $permissions
            ];

            return view('admin.roles.edit_permissions', $data);

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }


    public function updatePermissions(Request $request, $id)
    {

        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_role_permissions', $user_permissions)) {

            $role = $this->repository->getById($id);

            $role->permissions()->sync($request->permissions);

            Session::flash('success', 'Role permissions update');

            return redirect()->route('roles');

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function getRoles()
    {
        $data = $this->repository->getRoles();

        return $data['roles'];
    }

}
