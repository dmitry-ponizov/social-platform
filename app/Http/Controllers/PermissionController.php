<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Admin\Repositories\PermissionRepository;
use Illuminate\Support\Facades\Session;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;


    public function __construct(PermissionRepository $permission)
    {

        $this->repository = $permission;
    }

    public function index()
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_permission', $user_permissions)) {

            $data = $this->repository->getPermissions();

            return view('admin.permissions.index', compact('data'));

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

        if (in_array('create_permission', $user_permissions)) {

            return view('admin.permissions.create');

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

        if (in_array('create_permission', $user_permissions)) {

            $this->validate($request, [
                'label' => 'required|max:255',
                'type' => 'required',
                'lang.ru' => 'required',
                'lang.ua' => 'required',
                'lang.en' => 'required',
            ]);

            $permission_prepare = [
                'label' => $request->label,
                'type' => $request->type,
                'slug' => str_slug($request->label, '_'),
                'lang' => json_encode($request->lang)
            ];

            $this->repository->insert($permission_prepare);

            Session::flash('success', 'Permission created successfully.');

            return redirect()->route('permissions');
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

        if (in_array('edit_permission', $user_permissions)) {

            $permission = $this->repository->getById($id);

            $permission->lang = json_decode($permission->lang);

            $locale = \App::getlocale();

            $permission->locale = $permission->lang->$locale;

            $types = [
                'admin',
                'social',
                'volunteer',
                'organization'
            ];

            $data = [
                'types' => $types,
                'permission' => $permission
            ];
            return view('admin.permissions.edit', $data);

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

        if (in_array('edit_permission', $user_permissions)) {

            $this->validate($request, [
                'label' => 'required|max:255',
                'type' => 'required',
                'lang.ru' => 'required',
                'lang.ua' => 'required',
                'lang.en' => 'required',

            ]);

            $this->repository->savePermission($id, $request);


            Session::flash('success', 'Permission updated successfully.');

            return redirect()->route('permissions');


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

        if (in_array('delete_permission', $user_permissions)) {

            $this->repository->delete($id);

            Session::flash('success', 'Permission deleted successfully.');

            return redirect()->back();

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function editUsers($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_permission_users', $user_permissions)) {

            $permission = $this->repository->getById($id);

            $locale = \App::getLocale();

            $permission->lang = json_decode($permission->lang);

            $permission->lang = $permission->lang->$locale;

            $permission_users = $permission->users->toArray();

            $users = $this->repository->getUsers();

            $users = $users->toArray();

            foreach ($permission_users as $key => $user) {
                foreach ($users as &$value) {
                    if ($user['name'] == $value['name']) {
                        $value['checked'] = true;
                    }
                }

            }

            $data = [
                'permission' => $permission,
                'users' => $users
            ];

            return view('admin.permissions.edit_users', $data);
        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }


    public function updateUsers(Request $request, $id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_permission_users', $user_permissions)) {
            $permission = $this->repository->getById($id);

            $permission->users()->sync($request->users);

            Session::flash('success', 'Permission users update');

            return redirect()->route('permissions');
        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function editRoles($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_permission_roles', $user_permissions)) {

            $permission = $this->repository->getById($id);

            $locale = \App::getLocale();

            $permission->lang = json_decode($permission->lang);

            $permission->lang = $permission->lang->$locale;

            $permisiion_roles = $permission->roles->toArray();

            $roles = $this->repository->getRoles();

            $roles = $roles->toArray();

            foreach ($permisiion_roles as $key => $role) {
                foreach ($roles as &$value) {
                    if ($role['name'] == $value['name']) {
                        $value['checked'] = true;
                    }
                }

            }

            foreach ($roles as &$role) {
                $lang = json_decode($role['lang'], true);
                $role['lang'] = $lang[$locale];
            }


            $data = [
                'permission' => $permission,
                'roles' => $roles
            ];

            return view('admin.permissions.edit_roles', $data);

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function updateRoles(Request $request, $id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_permission_roles', $user_permissions)) {

            $permission = $this->repository->getById($id);

            $permission->roles()->sync($request->roles);

            Session::flash('success', 'Permission roles update');

            return redirect()->route('permissions');

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

}
