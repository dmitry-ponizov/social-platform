<?php

namespace App\Http\Controllers;

use App\Components\Main\Models\Statement;
use App\Events\StatementCreateEvent;
use App\Rules\Recaptcha;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Components\Main\Repositories\StatementRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Session;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;


class StatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(StatementRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {

        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_statements_list', $user_permissions)) {

            $data = $this->repository->getStatements();

            return view('admin.statements.index', compact('data'));

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
    public function create(Request $request)
    {

        $file = 'uploads/defaults/address/location.json';

        $categories = $this->repository->getCategories();

        $file_get = file_get_contents($file);

        $decode = json_decode($file_get, true);

        $regions = array_keys($decode);

        $lang = Lang::get('main.statement');

        $answer = [
            'categories' => $categories,
            'regions' => $regions,
            'lang' => $lang
        ];

        $data = [
            'answer' => $answer,
        ];


        return view('main.statements.create', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function rules(Request $request)
    {

        $this->validate($request, [
            'region' => 'required',
            'area' => 'required',
            'city' => 'required',
            'street' => 'required',
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        $category_rules = $this->repository->categoryRules($request);

        return $category_rules;
    }


    public function storeRules(Request $request)
    {
        $files = $request->file();

        $texts = $request->text;

        $text_rules = $request->text_id;

        $prepare = [];
        if (!empty($texts)) {
            foreach ($texts as $key => $value) {
                if (!empty($value)) {
                    $prepare[] = [
                        'user_id' => \Auth::id(),
                        'rule_id' => $text_rules[$key],
                        'data' => $value,
                        'changed_at' => Carbon::now()
                    ];
                }
            }
        }

        if (!empty($files)) {

            foreach ($files as $key => $file) {

                $uuid1 = Uuid::uuid1();

                $file_name = $uuid1->toString();

                $explode = explode('.', $file->getClientOriginalName());

                $count = count($explode);

                $exp = $explode[$count - 1];

                $file_new_name = $file_name . "." . $exp;

                $file->move('uploads/statements', $file_new_name);

                $prepare[] = [
                    'user_id' => \Auth::id(),
                    'rule_id' => $key,
                    'data' => '/uploads/statements/' . $file_new_name,
                    'changed_at' => Carbon::now()
                ];
            }


        }

        $answer = $this->repository->createProfiles($prepare);

    }

    public function store(Request $request)
    {

        $answer = $this->repository->storeStatement($request);

        return $answer ? response('ok', 200) : abort(401, 'Error');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_statement', $user_permissions)) {

            $statement = $this->repository->getRelations($id);

            return view('admin.statements.show', compact('statement'));


        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }

    }

    public function showSubstatement($id)
    {
        $statement = $this->repository->getSubstatement($id);

        return view('admin.statements.show', compact('statement'));
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

        if (in_array('edit_statement', $user_permissions)) {

            $statement = $this->repository->getRelations($id);

            $users = $this->repository->getUsers();

            $categories = $this->repository->getCategories();

            $statuses = ['sent', 'closed', 'accepted'];

            $data = [
                'statement' => $statement,
                'users' => $users,
                'statuses' => $statuses,
                'categories' => $categories
            ];

            return view('admin.statements.edit', $data);

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

        if (in_array('edit_statement', $user_permissions)) {
            $this->validate($request, [
                'title' => 'required|max:120',
                'category_id' => 'required',
                'description' => 'required',
            ]);

            $answer = $this->repository->updateStatement($request, $id);

            if ($answer) {
                Session::flash('success', 'Statement update successfully.');
            }


            return redirect()->route('statements');

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

        if (in_array('delete_statement', $user_permissions)) {

            $statement = $this->repository->getById($id);

            if (!empty($statement->image)) \File::delete('uploads/statements', $statement->image);

            $statement->delete();

            Session::flash('success', 'Statement deleted successfully.');

            return back();

        } else {

            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function noPublish($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('publish_statement', $user_permissions)) {
            $this->repository->noPublished($id);

            Session::flash('success', 'Statement no published.');

            return redirect()->back();

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }


    public function publish($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('publish_statement', $user_permissions)) {
            $this->repository->published($id);

            Session::flash('success', 'Statement published successfully.');

            return redirect()->back();

        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }
    }

    public function showRules($id)
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_rules_statement', $user_permissions)) {

            $statement = $this->repository->getById($id);

            $rules = $this->repository->getRules($statement);

            $lang = Lang::get('main.global.no_data');

            $data = [
                'statement' => $statement,
                'rules' => $rules,
                'lang' => $lang
            ];
            return view('admin.statements.show_rules', $data);
        } else {
            Session::flash('info', 'No permission!');

            return redirect()->route('admin.main');
        }

    }


    public function storeSocialService(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:32',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $result = $this->repository->createSocialStatement($request);

        if (!empty($result)) {
            return $result;
        } else {
            abort(422, 'Error');
        }
    }

    public function storeOrganization(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:70',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $result = $this->repository->createOrganizationStatement($request);

        return ($result) ? response($result, 200) : abort(422, 'Error');

    }

    public function getUsers()
    {
        $users = $this->repository->socialUsers();

        return $users;
    }

    public function getUserStatements(Request $request)
    {
        if ($request->has('user_id')) {
            $user_id = $request->user_id;
        } else {
            $user_id = auth()->id();
        }

        $result = $this->repository->getUserStatements($user_id);

        if ($result) {
            return $result;
        }
    }

    public function getStatement(Request $request)
    {
        $result = $this->repository->getStatement($request);

        return $result;
    }

    public function fieldUpdate(Request $request)
    {
        $result = $this->repository->fieldUpdate($request);

        return $result;
    }

    public function statusUpdate(Request $request)
    {
        $result = $this->repository->statusUpdate($request);

        return response()->json($result);
    }

    public function addImage(Request $request)
    {
        $result = $this->repository->addImage($request);

        return $result;
    }

    public function updateImage(Request $request)
    {
        $result = $this->repository->updateImage($request);

        return $result;
    }

    public function socialStatements()
    {
        $statements = $this->repository->getSocialStatements();

        if ($statements) {
            return $statements;
        } else {
            return 'error';
        }
    }

    public function noAccepted()
    {

        $statements = $this->repository->noAcceptedStatements('sent');

        if ($statements) return $statements;
        return 'error';

    }

    public function accepted()
    {
        $statements = $this->repository->statusStatements('accepted');

        if ($statements) return $statements;
        return 'error';
    }

    public function closed()
    {
        $statements = $this->repository->statusStatements('closed');

        return ($statements) ? $statements : 'error';
    }

    public function showStatement($id)
    {
        $statement = $this->repository->getStatement($id);

        $settings = $this->repository->getSettings();

        $data = [
            'statement' => $statement,
            'settings' => $settings
        ];

        return view('main.statements.show', $data);
    }

    public function getStatements()
    {
        $settings = $this->repository->getSettings();

        $categories = $this->repository->getCategories();

        $statements = $this->repository->paginationStatements();

        $data = [

            'settings' => $settings,
            'categories' => $categories,
            'stats' => $statements

        ];
        return view('main.statements.statements', $data);

    }

    public function pagination()
    {
        $statements = $this->repository->paginationStatements();

        return response()->json($statements);
    }

    public function statementsSearch(Request $request)
    {
        $search = $request->search;

        $result = $this->repository->search($search);

        return response()->json($result);
    }

    public function categoriesStatements(Request $request)
    {
        $cat_statements = $this->repository->categoriesStatements($request->categories);

        return response()->json($cat_statements);

    }

    public function storeSubOrganization(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:70',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $result = $this->repository->createOrganizationSubStatement($request);

        return $result ?: abort(422, 'Error');

    }

    public function getChildFromUuid()
    {

        $statement = $this->repository->getChildUuid(request()->uuid);

        return response()->json($statement);
    }

    public function getFromUuid()
    {
        $statement = $this->repository->getUuid(request()->uuid);

        return response()->json($statement);
    }

    public function history(Request $request)
    {

        $result = $this->repository->history($request->uuid);

        return response()->json($result);
    }


    public function writeAdmin(Request $request)
    {
        $this->validate($request, [
            'title' => 'required | max:50',
            'description' => 'required | max:255'
        ]);
        $result = $this->repository->createStatement($request);

        return ($result) ? response('ok', 200) : abort(422, 'Error');

    }

    public function statistics(Request $request)
    {
        $result = $this->repository->getStatistics($request->time, $request->type);

        return $result;
    }

    public function noAcceptedOrganization()
    {
        $statements = $this->repository->getOrganizationStatements();

        return response()->json($statements);
    }

    public function review()
    {
        request()->validate([
            'rate' => 'required',
            'comment' => 'required'
        ]);

        $rate = $this->repository->changeRate(
            request()->rate,
            request()->uuid,
            request()->comment
        );

        return ($rate) ? response($rate, 200) : abort(422, 'Error');
    }
}
