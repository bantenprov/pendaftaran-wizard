<?php
namespace Bantenprov\PendaftaranWizard\Http\Controllers;
/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/* Models */
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\JenisSekolah;
use App\User;
/* Etc */
use Auth;
/**
 * The JenisSekolahController class.
 *
 * @package Bantenprov\Sekolah
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class JenisSekolahController extends Controller
{
    protected $jenis_sekolah;
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->jenis_sekolah    = new JenisSekolah;
        $this->user             = new User;
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
            $query = $this->jenis_sekolah->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->jenis_sekolah->orderBy('id', 'asc');
        }
        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('jenis_sekolah', 'like', $value);
            });
        }
        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('user')->paginate($perPage);
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
        $jenis_sekolahs = $this->jenis_sekolah->with('user')->get();
        foreach($jenis_sekolahs as $jenis_sekolah){
            array_set($jenis_sekolah, 'label', $jenis_sekolah->jenis_sekolah);
        }
        $response['jenis_sekolahs']   = $jenis_sekolahs;
        $response['error']      = false;
        $response['message']    = 'Success';
        $response['status']     = true;
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
        $jenis_sekolah        = $this->jenis_sekolah->getAttributes();
        $users          = $this->user->getAttributes();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->findOrFail($user_id);
        $current_user   = Auth::User();
        $role_check = Auth::User()->hasRole(['superadministrator','administrator']);
        if($role_check){
            $user_special = true;
            foreach($users_special as $user){
                array_set($user, 'label', $user->name);
            }
            $users = $users_special;
        }else{
            $user_special = false;
            array_set($users_standar, 'label', $users_standar->name);
            $users = $users_standar;
        }
        array_set($current_user, 'label', $current_user->name);
        $response['jenis_sekolah']        = $jenis_sekolah;
        $response['users']          = $users;
        $response['user_special']   = $user_special;
        $response['current_user']   = $current_user;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;
        return response()->json($response);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;
        return response()->json($response);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\JenisSekolah  $jenis_sekolah
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jenis_sekolah = $this->jenis_sekolah->with(['user'])->findOrFail($id);
        $response['jenis_sekolah']    = $jenis_sekolah;
        $response['error']      = false;
        $response['message']    = 'Success';
        $response['status']     = true;
        return response()->json($response);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JenisSekolah  $jenis_sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jenis_sekolah = $this->jenis_sekolah->with(['user'])->findOrFail($id);
        $response['jenis_sekolah']    = $jenis_sekolah;
        $response['error']      = false;
        $response['message']    = 'Success';
        $response['status']     = true;
        return response()->json($response);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JenisSekolah  $jenis_sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;
        return response()->json($response);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JenisSekolah  $jenis_sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenis_sekolah = $this->jenis_sekolah->findOrFail($id);
        if ($jenis_sekolah->delete()) {
            $response['message']    = 'Success';
            $response['success']    = true;
            $response['status']     = true;
        } else {
            $response['message']    = 'Failed';
            $response['success']    = false;
            $response['status']     = false;
        }
        return json_encode($response);
    }
}