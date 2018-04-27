<?php
namespace Bantenprov\PendaftaranWizard\Http\Controllers;
/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* Models */
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\ProdiSekolah;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Sekolah;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\ProgramKeahlian;
use App\User;
/* Etc */
use Validator;
use Auth;
/**
 * The ProdiSekolahController class.
 *
 * @package Bantenprov\Sekolah
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProdiSekolahController extends Controller
{
    protected $prodi_sekolah;
    protected $sekolah;
    protected $program_keahlian;
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->prodi_sekolah    = new ProdiSekolah;
        $this->sekolah          = new Sekolah;
        $this->program_keahlian = new ProgramKeahlian;
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
            $query = $this->prodi_sekolah->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->prodi_sekolah->orderBy('id', 'asc');
        }
        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('keterangan', 'like', $value)
                    ->orWhere('kuota_siswa', 'like', $value);
            });
        }
        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with(['sekolah', 'program_keahlian', 'user'])->paginate($perPage);
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
        $prodi_sekolahs = $this->prodi_sekolah->with(['sekolah', 'program_keahlian', 'user'])->get();
        foreach($prodi_sekolahs as $prodi_sekolah){
            if (isset($prodi_sekolah->program_keahlian->label)) {
                array_set($prodi_sekolah, 'label', $prodi_sekolah->program_keahlian->label);
            } else {
                array_set($prodi_sekolah, 'label', 'Keterangan: '.$prodi_sekolah->keterangan);
            }
        }
        $response['prodi_sekolahs']   = $prodi_sekolahs;
        $response['error']      = false;
        $response['message']    = 'Success';
        $response['status']     = true;
        return response()->json($response);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBySekolah($id)
    {
        $prodi_sekolahs = $this->prodi_sekolah->where('sekolah_id', '=', $id)->with(['sekolah', 'program_keahlian', 'user'])->get();
        // dd($this->prodi_sekolah);
        foreach($prodi_sekolahs as $prodi_sekolah){
            if (isset($prodi_sekolah->program_keahlian->label)) {
                array_set($prodi_sekolah, 'label', $prodi_sekolah->program_keahlian->label);
            } else {
                array_set($prodi_sekolah, 'label', 'Keterangan: '.$prodi_sekolah->keterangan);
            }
        }
        $response['prodi_sekolahs'] = $prodi_sekolahs;
        $response['message']        = 'Success';
        $response['error']          = false;
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
        $prodi_sekolah      = $this->prodi_sekolah->getAttributes();
        $sekolahs           = $this->sekolah->getAttributes();
        $program_keahlians  = $this->program_keahlian->all();
        $users              = $this->user->getAttributes();
        $users_special      = $this->user->all();
        $users_standar      = $this->user->findOrFail($user_id);
        $current_user       = Auth::User();
        foreach($sekolahs as $sekolah){
            array_set($sekolah, 'label', $sekolah->nama);
        }
        foreach($program_keahlians as $program_keahlian){
            array_set($program_keahlian, 'label', $program_keahlian->label);
        }
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
        $response['prodi_sekolah']      = $prodi_sekolah;
        $response['sekolahs']           = $sekolahs;
        $response['program_keahlians']  = $program_keahlians;
        $response['users']              = $users;
        $response['user_special']       = $user_special;
        $response['current_user']       = $current_user;
        $response['error']              = false;
        $response['message']            = 'Success';
        $response['status']             = true;
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
        $prodi_sekolah = $this->prodi_sekolah;
        $validator = Validator::make($request->all(), [
            'sekolah_id'            => "required|exists:{$this->sekolah->getTable()},id",
            'program_keahlian_id'   => "required|exists:{$this->program_keahlian->getTable()},id|unique:{$this->prodi_sekolah->getTable()},program_keahlian_id,NULL,id,sekolah_id,{$request->input('sekolah_id')},deleted_at,NULL",
            'kuota_siswa'           => 'required|numeric|min:0|max:100000',
            'keterangan'            => 'required|max:255',
            'user_id'               => "required|exists:{$this->user->getTable()},id",
        ]);
        if ($validator->fails()) {
            $error      = true;
            $message    = $validator->errors()->first();
        } else {
            $prodi_sekolah->sekolah_id          = $request->input('sekolah_id');
            $prodi_sekolah->program_keahlian_id = $request->input('program_keahlian_id');
            $prodi_sekolah->kuota_siswa         = $request->input('kuota_siswa');
            $prodi_sekolah->keterangan          = $request->input('keterangan');
            $prodi_sekolah->user_id             = $request->input('user_id');
            $prodi_sekolah->save();
            $error      = false;
            $message    = 'Success';
        }
        $response['prodi_sekolah']  = $prodi_sekolah;
        $response['error']          = $error;
        $response['message']        = $message;
        $response['status']         = true;
        return response()->json($response);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\ProdiSekolah  $prodi_sekolah
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prodi_sekolah = $this->prodi_sekolah->with(['sekolah', 'program_keahlian', 'user'])->findOrFail($id);
        $response['prodi_sekolah']  = $prodi_sekolah;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;
        return response()->json($response);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prodi_sekolah = $this->prodi_sekolah->with(['sekolah', 'program_keahlian', 'user'])->findOrFail($id);
        $response['prodi_sekolah']  = $prodi_sekolah;
        $response['error']          = false;
        $response['message']        = 'Success';
        $response['status']         = true;
        return response()->json($response);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = array();
        $message  = array();
        $prodi_sekolah = $this->prodi_sekolah->findOrFail($id);
            $validator = Validator::make($request->all(), [
                'sekolah_id'             => 'required',
                'user_id'                => 'required|unique:prodi_sekolahs,user_id,'.$id,
                'keterangan'             => 'required',
                'kuota_siswa'            => 'required',
                'program_keahlian_id'    => 'required',
            ]);
            if($validator->fails()){
                foreach($validator->messages()->getMessages() as $key => $error){
                    foreach($error AS $error_get) {
                        array_push($message, $error_get);
                    }
                }
                $check_user   = $this->prodi_sekolah->where('id','!=', $id)->where('user_id', $request->user_id);
            if($check_user->count() > 0){
                    $response['message'] = implode("\n",$message);
            } else {
                $prodi_sekolah->sekolah_id          = $request->input('sekolah_id');
                $prodi_sekolah->user_id             = $request->input('user_id');
                $prodi_sekolah->program_keahlian_id = $request->input('program_keahlian_id');
                $prodi_sekolah->keterangan          = $request->input('keterangan');
                $prodi_sekolah->kuota_siswa         = $request->input('kuota_siswa');
                $prodi_sekolah->save();
                $response['message'] = 'success';
            }
        } else {
                $prodi_sekolah->sekolah_id          = $request->input('sekolah_id');
                $prodi_sekolah->user_id             = $request->input('user_id');
                $prodi_sekolah->program_keahlian_id = $request->input('program_keahlian_id');
                $prodi_sekolah->keterangan          = $request->input('keterangan');
                $prodi_sekolah->kuota_siswa         = $request->input('kuota_siswa');
                $prodi_sekolah->save();
            $response['message'] = 'success';
        }
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prodi_sekolah = $this->prodi_sekolah->findOrFail($id);
        if ($prodi_sekolah->delete()) {
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
