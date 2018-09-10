<?PHP

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Admin\Repositories\AdminRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $repository;


    public function __construct(AdminRepository $admin)
    {
        $this->repository = $admin;
    }

    public function index()
    {
        $user_permissions = $this->repository->userPermissions();

        if (in_array('view_admin', $user_permissions)) {

            return view('admin.index');

        } else {
            Session::flash('info', 'No permission!');

            return redirect('/');
        }
    }

    public function locale($lang)
    {

        app()->setLocale($lang);

        return redirect()->route('admin.main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
