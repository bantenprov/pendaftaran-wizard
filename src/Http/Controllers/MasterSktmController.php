<?php
namespace Bantenprov\PendaftaranWizard\Http\Controllers;
/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/* Models */
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\MasterSktm;
use App\User;
/* Etc */
use Validator;
use Auth;
/**
 * The MasterSktmController class.
 *
 * @package Bantenprov\Sktm
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class MasterSktmController extends Controller
{
    protected $master_sktm;
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->master_sktm  = new MasterSktm;
        $this->user         = new User;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);
            $query = $this->master_sktm->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->master_sktm->orderBy('id', 'asc');
        }
        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('nama', 'like', $value)
                    ->orWhere('instansi', 'like', $value);
            });
        }
        $perPage    = request()->has('per_page') ? (int) request()->per_page : null;
        $response   = $query->with(['user'])->paginate($perPage);
        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $master_sktms = $this->master_sktm->with(['user'])->get();
        $response['master_sktms']   = $master_sktms;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;
        return response()->json($response);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id        = isset(Auth::User()->id) ? Auth::User()->id : null;
        $master_sktm    = $this->master_sktm->getAttributes();
        $users          = $this->user->getAttributes();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->findOrFail($user_id);
        $current_user   = Auth::User();
        $role_check = Auth::User()->hasRole(['superadministrator','administrator']);
        if ($role_check) {
            $user_special = true;
            foreach ($users_special as $user) {
                array_set($user, 'label', $user->name);
            }
            $users = $users_special;
        } else {
            $user_special = false;
            array_set($users_standar, 'label', $users_standar->name);
            $users = $users_standar;
        }
        array_set($current_user, 'label', $current_user->name);
        $response['master_sktm']    = $master_sktm;
        $response['users']          = $users;
        $response['user_special']   = $user_special;
        $response['current_user']   = $current_user;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;
        return response()->json($response);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\MasterSktm  $master_sktm
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $master_sktm = $this->master_sktm->with(['user'])->findOrFail($id);
        $response['master_sktm']    = $master_sktm;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;
        return response()->json($response);
    }
}
