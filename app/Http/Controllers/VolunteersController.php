<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Admin\Repositories\VolunteerRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Session;

class VolunteersController extends Controller
{

    protected $repository;


    public function __construct(VolunteerRepository $volunteer)
    {
        $this->repository = $volunteer;
    }

    public function create($id)
    {
        return view('admin.volunteers.create', compact('id'));
    }

    public function store($id, Request $request)
    {
        $this->validate($request, [
            'phone' => [
                'required',
                'unique:users',
                'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
            ],
        ]);
        $prepare = [
            'name' => htmlspecialchars(trim($request->name)),
            'uuid' => Str::uuid(),
            'surname' => htmlspecialchars(trim($request->surname)),
            'phone' => htmlspecialchars(trim($request->phone)),
            'organization_id' => $id,
            'types' => 'volunteer',
            'position' => 'volunteer',
            'password' =>  Hash::make($request->password),
            'avatar' => '/uploads/avatars/no_avatar.jpeg',
        ];

        $volunteer = $this->repository->createVolunteer($prepare);

        if ($volunteer) {
            Session::flash('success', 'User create successfully!');

            return redirect()->route('organizations.show', $id);

        }
    }

    public function update(Request $request)
    {

        $result = $this->repository->updateVolunteersBlock($request);

        if ($result) {

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content', 'volunteers');
        }
    }

    public function countUpdate(Request $request)
    {
        $result = $this->repository->updateCount($request);

        if ($result) {

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content', 'volunteers');
        }
    }

    public function becomeVoluteer(Request $request)
    {
        $result = $this->repository->becomeVolunteer($request);

        if ($result) {

            Session::flash('success', 'Element updated!');

            return redirect()->route('element.content', 'become_volunteer');
        }
    }

    public function show($uuid)
    {
        $volunteer = $this->repository->getVolunteer($uuid);

        return view('main.volunteers.show', compact('volunteer'));
    }
}