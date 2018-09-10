<?php

namespace App\Components\Admin\Repositories;

use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\Organization;
use App\Components\Admin\Models\OrganizationDocument;
use App\Components\Admin\Models\User;
use App\Components\Main\Models\Category;
use App\Components\Main\Models\Statement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class OrganizationRepository extends BaseRepository
{

    protected $model, $document_model, $locale, $category_model, $social_repo;


    public function __construct(
        Organization $organization,
        OrganizationDocument $document,
        Category $category,
        SocialServiceRepository $social_repo
    )
    {
        $this->model = $organization;
        $this->document_model = $document;
        $this->category_model = $category;
        $this->social_repo = $social_repo;

    }

    public function saveField($request)
    {
        $user = \Auth::user();

        $field = $request->field;

        $value = $request->value;

        $social = $this->model->find($user->organization_id);

        $social->$field = $value;

        $social->save();

        $response ['field'] = $field;

        $response ['value'] = $social->$field;

        return $response;


    }

    public function saveInfo($request)
    {
        $user = \Auth::user();

        $social = $this->model->find($user->organization_id);

        foreach ($request->data as $key => $value) {
            $social->$key = $value;
        }

        $social->save();

        $social_service = array_filter($social->toArray(), function ($k) {
            return $k !== 'id' && $k !== 'created_at' && $k !== 'block' && $k !== 'users' && $k !== 'slug' && $k !== 'volunteersCount' && $k !== 'updated_at';
        }, ARRAY_FILTER_USE_KEY);

        return $social_service;
    }

    public function createDocument($request)
    {
        $name = htmlspecialchars(trim($request->name));

        $exists = $this->document_model->where('name', $name)->exists();

        if ($exists) {
            abort(422, 'This document exists');
        }

        $files = $request->file('files');

        if (!empty($files)) {
            foreach ($files as $key => $file) {

                list($exp, $new_file_path) = $this->moveFile($file);

                $prepare[] = [
                    'name' => $name,
                    'slug' => str_slug($name, '_'),
                    'type' => $exp,
                    'organization_id' => \Auth::user()->organization_id,
                    'data' => $new_file_path,
                    'created_at' => Carbon::now()
                ];
            }

            $this->document_model->insert($prepare);

            $documents = $this->document_model->where('organization_id', \Auth::user()->organization_id)->where('name', $name)->get();

            $result = [];

            foreach ($documents as $document) {
                $result[$document->name][$document->id] = [
                    'id' => $document->id,
                    'type' => $document->type,
                    'name' => $document->name,
                    'data' => $document->data,
                    'organization_id' => $document->organization_id,
                ];
            }

            return $result;
        } else {
            abort(422, 'File don`t exists');
        }

    }


    public function deleteDocumentPage($id)
    {
        $document = $this->document_model->find($id);

        $document->delete();

        \File::delete('uploads/organization/' . $document->data);

        return $document;
    }

    public function addDocument($request)
    {
        $document = $this->document_model;

        $file = $request->file('file');

        list($exp, $new_file_path) = $this->moveFile($file);

        $document->name = $request->data;

        $document->slug = str_slug($request->data);

        $document->data = $new_file_path;

        $document->organization_id = auth()->user()->organization_id;

        $document->type = $exp;

        $document->save();

        $result = [
            'id' => $document->id,
            'type' => $document->type,
            'name' => $document->name,
            'data' => $document->data,
            'organization_id' => $document->organization_id,
        ];

        return $result;
    }

    public function updateDocument($request)
    {
        $document = $this->document_model->find($request->data);

        $file = $request->file('file');

        list($exp, $new_file_path) = $this->moveFile($file);

        $document->data = $new_file_path;

        $document->type = $exp;

        $document->save();

        $result = [
            'id' => $document->id,
            'type' => $document->type,
            'name' => $document->name,
            'data' => $document->data,
            'organization_id' => $document->organization_id,
        ];

        return $result;
    }

    /**
     * @param $uuid1
     * @param $file
     * @return array
     */
    protected function moveFile($file): array
    {
        $uuid1 = Str::uuid();

        $file_name = $uuid1->toString();

        $explode = explode('.', $file->getClientOriginalName());

        $count = count($explode);

        $exp = $explode[$count - 1];

        $file_new_name = $file_name . "." . $exp;

        $file->move('uploads/organization', $file_new_name);

        $new_file_path = $file_new_name;

        return array($exp, $new_file_path);
    }

    public function addCategory($id)
    {
        $category = $this->category_model->find($id);

        $locale = \App::getLocale();

        $category->organizations()->attach(auth()->user()->organization_id);

        $lang = json_decode($category->lang);


        return [
            'id' => $category->id,
            'title' => $lang->$locale
        ];

    }

    public function deleteCategory($id)
    {
        $category = $this->category_model->find($id);

        $category->organizations()->detach(auth()->user()->organization_id);

        $lang = json_decode($category->lang);

        $locale = \App::getLocale();

        return [
            'id' => $category->id,
            'title' => $lang->$locale
        ];

    }


    public function blockOrganization($id)
    {
        $organization = $this->model->with('users')->find($id);

        $organization->update(['block' => !$organization->block]);

        foreach ($organization->users as $user) {
            $user->update(['block' => $organization->block]);
        }

        return true;
    }


    public function volunteerRegistration($request)
    {
        return User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'uuid' => Str::uuid(),
            'avatar' => '/uploads/avatars/no_avatar.jpeg',
            'types' => 'volunteer',
            'organization_id' => auth()->user()->organization_id,
            'password' => Hash::make($request->password),
            'phone' => $request->phone
        ]);

    }

    public function getOrganizationData($organization)
    {
        $organization->statements_count = $organization->statementCount();

        $organization
            ->load('categories')
            ->load('events')
            ->load(['statements' => function ($query) {
                $query->with(['images' => function ($query) {
                    $query->where('main', 1);
                }])->where('parent_id', 0)
                    ->where('status', '!=', 'closed')
                    ->latest()
                    ->limit(10);
            }]);

        return $organization;

    }

    public function getStatements($id)
    {
        return Statement::where('organization_id', $id)
            ->with('user')
            ->paginate(20);

    }

    public function changeLogo($file)
    {
        try {
            switch (auth()->user()->types) {
                case('volunteer'):
                    list($exp, $new_file_path) = $this->moveFile($file);
                    $this->model
                        ->where('id', auth()->user()->organization_id)
                        ->update(['logo' => $new_file_path]);
                    break;
                default:
                    $new_file_path = $this->social_repo->changeLogo($file);
                    break;
            }
            if($new_file_path) {
                return [auth()->user()->types => $new_file_path];
            }
            return false;

        } catch (\Exception $e) {
            return false;
        }

    }
}