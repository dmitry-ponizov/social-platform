<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Egulias\EmailValidator\Validation\Error\RFCWarnings;
use Illuminate\Http\Request;
use App\Components\Admin\Repositories\SocialServiceRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Session;


class SocialServiceController extends Controller
{
    protected $repository;


    public function __construct(SocialServiceRepository $social)
    {

        $this->repository = $social;
    }

    public function index()
    {
        $social_services = $this->repository->getAll();

        return view('admin.social_services.index', compact('social_services'));
    }

    public function create()
    {
        return view('admin.social_services.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,
            [
                "org_name" => "required|string|max:255",
                "name" => "required|string|max:255",
                "surname" => "required|string|max:32",
                "city" => "required|string|max:32",
                "street" => "required|string|max:32",
                "house" => "required|string|max:32",
                "office" => "required|string|max:32",
                "email" => "required|string|max:32",
                'phone' => [
                    'required',
                    'unique:users',
                    'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
                ],
                'password' => 'required|string|min:6',
            ]);

        $attr = [
            "name" => $request->org_name,
            "city" => $request->city,
            "street" => $request->street,
            "house" => $request->house,
            "office" => $request->office,
            "phone" => $request->phone,
            "email" => $request->email,
            'created_at' => Carbon::now()
        ];


        $soc_service = $this->repository->create($attr);

        $role = $this->repository->getChiefRole();

        $attr_user = [
            'name' => $request->name,
            'uuid' => Str::uuid(),
            'surname' => $request->surname,
            'phone' => $request->phone,
            'social_service_id' => $soc_service->id,
            'types' => 'social-service',
            'position' => 'chief',
            'password' =>  Hash::make($request->password),
            'avatar' => '/uploads/avatars/no_avatar.jpeg',
        ];


        $user = $this->repository->createUser($attr_user);

        $user->roles()->sync($role);

        Session::flash('success', 'Social service created successfully.');

        return redirect()->route('social_services');
    }

    public function show($id)
    {
        $social_service = $this->repository->getService($id);

        $social_service->toArray();

        $data = [
            'social_service' => $social_service,

        ];

        return view('admin.social_services.show', $data);
    }

    public function createCoWork($id)
    {
        return view('admin.social_services.create_co_work', compact('id'));
    }

    public function storeCoWork(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
            'position' => 'required',
            'phone' => 'required',
            'password' => 'required'
        ]);

        $user_attr = [
            'name' => $request->name,
            'surname' => $request->surname,
            'uuid' => Str::uuid(),
            'types' => 'co-worker',
            'phone' => $request->phone,
            'position' => $request->position,
            'password' => Hash::make($request->password),
            'avatar' => '/uploads/avatars/no_avatar.jpeg',
            'social_service_id' => $id
        ];

        $user = $this->repository->createUser($user_attr);

        if ($user) {
            Session::flash('success', 'User create successfully!');

            return redirect()->route('show.social_service', $id);
        }

    }

    public function edit($id)
    {
        $social_service = $this->repository->getById($id);

        return view('admin.social_services.edit', compact('social_service'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
            [
                "name" => "required|string|max:255",
                "city" => "required|string|max:32",
                "street" => "required|string|max:32",
                "house" => "required|string|max:32",
                "office" => "required|string|max:32",
                "phone" => "required|string|max:32",
                "email" => "required|string|max:32",
            ]);

        $attr = [
            "name" => $request->name,
            "city" => $request->city,
            "street" => $request->street,
            "house" => $request->house,
            "office" => $request->office,
            "phone" => $request->phone,
            "email" => $request->email,
            'created_at' => Carbon::now()
        ];

        $this->repository->update($id, $attr);

        Session::flash('success', 'Social service updated successfully.');

        return redirect()->route('social_services');

    }

    public function saveField(Request $request)
    {
        $response = $this->repository->saveField($request);

        return response($response, 200);
    }

    public function saveInfo(Request $request)
    {
        return $response = $this->repository->saveInfo($request);
    }

    public function workerRegistration(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:32',
            'surname' => 'required|string|max:32',
            'role_id' => 'required',
            'phone' => [
                'required',
                'unique:users',
                'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
            ],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $answer = $this->repository->workerRegistration($request);

        return $answer ? response($answer, 200) : back();

    }

    public function createStatement($id)
    {
        return view('admin.social_services.create_statement', compact('id'));
    }
}