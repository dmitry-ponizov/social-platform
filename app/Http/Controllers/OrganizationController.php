<?php

namespace App\Http\Controllers;

use App\Components\Admin\Models\Organization;
use App\Http\Requests\StoreOrganizationRequest;
use Illuminate\Http\Request;
use App\Components\Admin\Repositories\OrganizationRepository;
use App\Components\Admin\Repositories\VolunteerRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrganizationController extends Controller
{
    protected $repository, $volunteer_repository;


    public function __construct(
        OrganizationRepository $organization,
        VolunteerRepository $volunteer
    )
    {
        $this->repository = $organization;
        $this->volunteer_repository = $volunteer;
    }

    public function index()
    {
        $organizations = $this->repository->getAll();

        return view('admin.organizations.index', compact('organizations'));
    }

    public function getList()
    {
        $organizations = $this->repository->fetchAll();

        return view('main.organization.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.create');
    }

    public function store(StoreOrganizationRequest $request)
    {
        $organization = $this->repository->create([
            "name" => $request->name,
            "slug" => str_slug($request->name, '_'),
            "city" => $request->city,
            "street" => $request->street,
            "house" => $request->house,
            "office" => $request->office,
            "phone" => $request->organization_phone,
            "email" => $request->email,
            'created_at' => Carbon::now()
        ]);

        $this->volunteer_repository->createVolunteer([
            'name' => $request->user_name,
            'uuid' => Str::uuid(),
            'surname' => $request->surname,
            'phone' => $request->phone,
            'organization_id' => $organization->id,
            'types' => 'volunteer',
            'position' => 'volunteer',
            'password' => Hash::make($request->password),
            'avatar' => '/uploads/avatars/no_avatar.jpeg',
        ]);

        Session::flash('success', 'Organization created successfully.');

        return redirect('/admin/organizations');
    }

    public function edit($id)
    {
        $organization = $this->repository->getById($id);

        return view('admin.organizations.edit', compact('organization'));
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

        Session::flash('success', 'Organization updated successfully.');

        return redirect()->route('organizations');

    }

    public function show($id)
    {
        $organization = $this->repository->getById($id);

        return view('admin.organizations.show', compact('organization'));
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

    public function createDocument()
    {
        $this->validate(request(), [
            'name' => 'required|max:50',
            'files' => 'required',
            'files.*' => 'max:10000|mimes:jpeg,gif,png,jpg,doc,pdf'
        ]);

        $document = $this->repository->createDocument(request());

        return response()->json($document);

    }

    public function deleteDocumentPage()
    {
        $result = $this->repository->deleteDocumentPage(request()->id);

        return response()->json($result);
    }

    public function updateDocument()
    {
        $result = $this->repository->updateDocument(request());

        return response()->json($result);
    }

    public function addDocument()
    {
        $result = $this->repository->addDocument(request());

        return response()->json($result);
    }

    public function addCategory()
    {
        $categories = $this->repository->addCategory(request()->category_id);

        return response()->json($categories);
    }

    public function deleteCategory()
    {
        $categories = $this->repository->deleteCategory(request()->category_id);

        return response()->json($categories);
    }


    public function block($id)
    {
        $result = $this->repository->blockOrganization($id);

        return ($result) ? redirect()->back() : abort(422, 'Error');
    }


    public function createVolunteer(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:32',
            'surname' => 'required|string|max:32',
            'phone' => [
                'required',
                'unique:users',
                'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
            ],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $answer = $this->repository->volunteerRegistration($request);

        return ($answer) ?: abort(422, 'Error');

    }

    public function details(Organization $organization)
    {
        $organization = $this->repository->getOrganizationData($organization);

        return view('main.organization.show', compact('organization'));
    }

    public function createStatement($id)
    {
        return view('admin.organizations.create_statement', compact('id'));
    }

    public function getOrganizationStatements($id)
    {
        $statements = $this->repository->getStatements($id);

        return view('admin.organizations.statements', compact('statements'));
    }

    public function changeLogo(Request $request)
    {
        $this->validate(request(), [
            'file' => 'required|max:10000|mimes:jpeg,gif,png,jpg',
        ]);

        $file = $request->file('file');

        $result = $this->repository->changeLogo($file);

        return $result ? response()->json($result) : ['error', 'Logo not changed!'];

    }
}