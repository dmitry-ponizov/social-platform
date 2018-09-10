<?php

namespace App\Http\Controllers;

use App\Components\Admin\Models\User;
use Illuminate\Http\Request;
use App\Components\Admin\Repositories\UserRepository;
use App\Components\Admin\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Lang;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;
    protected $profileRepository;
    protected $permissions;

    public function __construct(UserRepository $repository, ProfileRepository $profile)
    {
        $this->repository = $repository;
        $this->profileRepository = $profile;
    }

    public function index()
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_user', $user_permissions)) {

            $data = $this->repository->allUsers();

            return view('admin.users.index', compact('data'));
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

        if (in_array('create_user', $user_permissions)) {

            return view('admin.users.create');

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

        if (in_array('create_user', $user_permissions)) {
            $this->validate($request, [
                'name' => 'required',
                'surname' => 'required',
                'phone' => [
                    'required',
                    'unique:users',
                    'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
                ],
                'password' => 'required',
                'code' => 'required'
            ]);

            $user_attr = [
                'name' => $request->name,
                'surname' => $request->surname,
                'uuid' => Str::uuid(),
                'types' => 'destitute',
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'avatar' => '/uploads/avatars/no_avatar.jpeg'
            ];

            $user = $this->repository->create($user_attr);

            $result = $this->repository->saveProfiles($user, $request);

            $this->repository->addProfile($user->id, $request->code);

            if ($result) Session::flash('success', 'User create successfully!');

            return redirect()->route('users');

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
        $data = $this->repository->showUser($id);

        return view('admin.users.show', compact('data'));
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

        if (in_array('edit_user', $user_permissions)) {

            $user = $this->repository->getUser($id);

            return view('admin.users.edit', compact('user'));

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

        if (in_array('edit_user', $user_permissions)) {

            $this->validate($request, [
                'name' => 'required',
                'surname' => 'required',
                'identification_number' => 'required|numeric',
                'mobile_phone' => [
                    'required',
                    'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
                ],

            ]);

            $user = $this->repository->updateUser($request, $id);

            $result = $this->repository->updateProfiles($user, $request);

            if ($result) {
                Session::flash('success', 'Account profile update');
            }

            return redirect()->route('users');

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

        if (in_array('delete_user', $user_permissions)) {

            $user = $this->repository->getByid($id);

            $user->delete();

            Session::flash('success', 'User deleted');

            return redirect()->back();

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function editRoles($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_user_roles', $user_permissions)) {

            $user = $this->repository->getById($id);

            $user_roles = $user->roles->toArray();

            $roles = $this->repository->getRoles();

            $roles = $roles->toArray();

            $locale = \App::getLocale();

            foreach ($user_roles as $key => $role) {
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
                'user' => $user,
                'roles' => $roles
            ];

            return view('admin.users.edit_roles', $data);
        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function updateRoles(Request $request, $id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_user_roles', $user_permissions)) {

            $user = $this->repository->getById($id);

            $user->roles()->sync($request->roles);

            Session::flash('success', 'User roles update');

            return redirect()->route('users');

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function editPermissions($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_user_permissions', $user_permissions)) {

            $user = $this->repository->getById($id);

            $user_permissions = $user->permissions->toArray();


            $permissions = $this->repository->getPermissions();

            $permissions = $permissions->toArray();

            $locale = \App::getLocale();

            foreach ($user_permissions as $key => $permission) {
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
                'user' => $user,
                'permissions' => $permissions
            ];

            return view('admin.users.edit_permissions', $data);

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function updatePermissions(Request $request, $id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('edit_user_permissions', $user_permissions)) {

            $user = $this->repository->getById($id);

            $user->permissions()->sync($request->permissions);

            Session::flash('success', 'User permissions update');

            return redirect()->route('users');
        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function acceptRules(Request $request, $id)
    {
        $this->repository->acceptRules($request, $id);

        Session::flash('success', 'Rules user is update!');

        return redirect()->back();
    }

    public function personalArea()
    {
        $user = \Auth::user();

        if (!$user->block) {

            if ($user->types === 'destitute' || $user->types === 'volunteer' || $user->types === 'admin') {

                $result = $this->repository->getUserData($user);

            }

            $accepted_cat = $this->repository->getAccCategories();

            $categories = $this->repository->getCategories();

            $routes = $this->repository->getRoutes($user);

            if(count($routes) === 0) {
              return redirect()->back();
            }

            $messages = $this->repository->getLang();

            $data = [
                'user' => $user,
                'user_data' => (isset($result)) ? $result : '',
                'messages' => $messages,
                'categories' => $categories,
                'accepted_categories' => (isset($accepted_cat)) ? $accepted_cat : '',
                'routes' => $routes,
            ];

            return view('main.users.personal_area', $data);

        } else {
            \Auth::logout();

            Session::flash('info', 'No permission!');

            return redirect('/');
        }


    }


    public function changeAvatar(Request $request)
    {
        if ($request->hasFile('file')) {

            $user = \Auth::user();

            $file = $request->file;

            $uuid1 = Uuid::uuid1();

            $file_name = $uuid1->toString();

            $explode = explode('.', $file->getClientOriginalName());

            $count = count($explode);

            $exp = trim($explode[$count - 1]);


            if (($exp == 'jpeg') || ($exp == 'jpg') || ($exp == 'png') || ($exp == 'gif')) {

                $current_avatar = $user->avatar;

                $file_new_name = $file_name . "." . $exp;

                $file->move('uploads/avatars', $file_new_name);

                $user->avatar = '/uploads/avatars/' . $file_new_name;

                $user->save();

                if ($current_avatar != "/uploads/avatars/no_avatar.jpeg") {

                    \File::delete('uploads/avatars', $current_avatar);
                }

                return $user->avatar;

            } else {
                return 'error';
            }


        }
    }

    public function updateOneField(Request $request)
    {
        $answer = $this->repository->fieldUpdate($request);

        return $answer ? response()->json($answer) : abort(400, 'Error');

    }

    public function updateAllInformation(Request $request)
    {

        $answer = $this->repository->updateFields($request);

        return $answer ? response()->json($answer) : abort(400, 'Error');
    }

    public function getRules(Request $request)
    {

        $parent_group_id = $request->group_id;

        $answer = $this->repository->getRules($parent_group_id);

        return $answer ? response()->json($answer) : abort(400, 'Error');

    }

    public function fileUpdate(Request $request)
    {
        if ($request->hasFile('file')) {

            return $this->repository->saveFile($request);

        }


    }

    public function addCategory(Request $request)
    {
        $answer = $this->repository->checkUserCategory($request);

        return $answer ? response()->json($answer) : abort(400, 'Error');
    }

    public function search(Request $request)
    {
        return $this->repository->search($request);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:32',
            'surname' => 'required|string|max:32',
            'code' => 'required',
            'gender' => 'required',
            'phone' => [
                'required',
                'unique:users',
                'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
            ],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $answer = $this->repository->createUser($request);

        return $answer ? response()->json($answer) : abort(400, 'Error');

    }

    public function userBlock($id)
    {

        $result = $this->repository->userBlock($id);

        return ($result) ? redirect()->back() : abort(422, 'error');
    }

    public function getVolunteers()
    {
        $volunteers = $this->repository->volunteers();

        $data = [
            'volunteers' => $volunteers
        ];
        return view('admin.volunteers.index', $data);
    }

    public function userPublish($id)
    {

        $result = $this->repository->userPublish($id);

        return ($result) ? redirect()->back() : abort(422, 'error');
    }


}
