<?php
namespace Bantenprov\PendaftaranWizard\Http\Controllers;
/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\OrangTua\Facades\OrangTuaFacade;
/* Models */
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\OrangTua;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Siswa;
use App\User;
/* Etc */
use Validator;
/**
 * The OrangTuaController class.
 *
 * @package Bantenprov\OrangTua
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class OrangTuaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     protected $orang_tua;
     protected $siswa;
     protected $user;
    public function __construct(OrangTua $orang_tua, User $user, Siswa $siswa)
    {
        $this->orang_tua = $orang_tua;
        $this->siswa = $siswa;
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('sort')) {
            list($sortCol, $sortDir) = explode('|', $request->sort);
            $query = $this->orang_tua->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->orang_tua->orderBy('id', 'asc');
        }
        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
               $value = "%{$request->filter}%";
                $q->where('id', 'like', $value)
                  ->orWhere('nama_ayah', 'like', $value);
            });
        }
        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->with('user')->with('siswa')->paginate($perPage);
        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = [];
        $siswas = $this->siswa->all();
        $users_special = $this->user->all();
        $users_standar = $this->user->find(\Auth::User()->id);
        $current_user = \Auth::User();
        $role_check = \Auth::User()->hasRole(['superadministrator','administrator']);
        if($role_check){
            $response['user_special'] = true;
            foreach($users_special as $user){
                array_set($user, 'label', $user->name);
            }
            $response['user'] = $users_special;
        }else{
            $response['user_special'] = false;
            array_set($users_standar, 'label', $users_standar->name);
            $response['user'] = $users_standar;
        }
        array_set($current_user, 'label', $current_user->name);
        foreach($siswas as $siswa){
            array_set($siswa, 'label', $siswa->nama_siswa);
        }
        $response['current_user'] = $current_user;
        $response['siswa'] = $siswas;
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\OrangTua  $orang_tua
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orang_tua = $this->orang_tua;
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:orangtuas,user_id',
            'nomor_un' => 'required|unique:orangtuas,nomor_un',
            'no_telp'   => 'required|unique:orangtuas,no_telp',
            'nama_ayah'   => 'required',
            'nama_ibu'   => 'required',
            'pendidikan_ayah'   => 'required',
            'kerja_ayah'   => 'required',
            'pendidikan_ibu'   => 'required',
            'kerja_ibu'   => 'required',
            'alamat_ortu'   => 'required',
        ]);
        if($validator->fails()){
            $check = $orang_tua->where('user_id',$request->user_id)->orWhere('nomor_un',$request->nomor_un)->orWhere('no_telp',$request->no_telp)->whereNull('deleted_at')->count();
            if ($check > 0) {
                $response['message'] = 'Failed ! Username, Nama Siswa, Nomor Telp already exists';
            } else {
            $orang_tua->user_id = $request->input('user_id');
            $orang_tua->nomor_un = $request->input('nomor_un');
            $orang_tua->no_telp = $request->input('no_telp');
            $orang_tua->nama_ayah = $request->input('nama_ayah');
            $orang_tua->nama_ibu = $request->input('nama_ibu');
            $orang_tua->pendidikan_ayah = $request->input('pendidikan_ayah');
            $orang_tua->kerja_ayah = $request->input('kerja_ayah');
            $orang_tua->pendidikan_ibu = $request->input('pendidikan_ibu');
            $orang_tua->kerja_ibu = $request->input('kerja_ibu');
            $orang_tua->alamat_ortu = $request->input('alamat_ortu');
            $orang_tua->save();
            $response['message'] = 'success';
            }
            } else {
            $orang_tua->user_id = $request->input('user_id');
            $orang_tua->nomor_un = $request->input('nomor_un');
            $orang_tua->no_telp = $request->input('no_telp');
            $orang_tua->nama_ayah = $request->input('nama_ayah');
            $orang_tua->nama_ibu = $request->input('nama_ibu');
            $orang_tua->pendidikan_ayah = $request->input('pendidikan_ayah');
            $orang_tua->kerja_ayah = $request->input('kerja_ayah');
            $orang_tua->pendidikan_ibu = $request->input('pendidikan_ibu');
            $orang_tua->kerja_ibu = $request->input('kerja_ibu');
            $orang_tua->alamat_ortu = $request->input('alamat_ortu');
            $orang_tua->save();
            $response['message'] = 'success';
            }
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orang_tua = $this->orang_tua->findOrFail($id);
        $response['user'] = $orang_tua->user;
        $response['siswa'] = $orang_tua->siswa;
        $response['orang_tua'] = $orang_tua;
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrangTua  $orang_tua
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orang_tua = $this->orang_tua->findOrFail($id);
        array_set($orang_tua->user, 'label', $orang_tua->user->name);
        array_set($orang_tua->siswa, 'label', $orang_tua->siswa->nama_siswa);
        $response['user'] = $orang_tua->user;
        $response['siswa'] = $orang_tua->siswa;
        $response['orang_tua'] = $orang_tua;
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrangTua  $orang_tua
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = array();
        $message  = array();
        $orang_tua = $this->orang_tua->findOrFail($id);
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|unique:orangtuas,user_id,'.$id,
            'nomor_un' => 'required|unique:orangtuas,nomor_un,'.$id,
            'no_telp'   => 'required|unique:orangtuas,no_telp,'.$id,
            'nama_ayah'   => 'required',
            'nama_ibu'   => 'required',
            'pendidikan_ayah'   => 'required',
            'kerja_ayah'   => 'required',
            'pendidikan_ibu'   => 'required',
            'kerja_ibu'   => 'required',
            'alamat_ortu'   => 'required',
        ]);
        if ($validator->fails()) {
            foreach($validator->messages()->getMessages() as $key => $error){
                        foreach($error AS $error_get) {
                            array_push($message, $error_get);
                        }
                    }
             $check_user     = $this->orang_tua->where('id','!=', $id)->where('user_id', $request->user_id);
             $check_siswa = $this->orang_tua->where('id','!=', $id)->where('nomor_un', $request->nomor_un);
             $check_no_telp = $this->orang_tua->where('id','!=', $id)->where('no_telp', $request->no_telp);
             if($check_user->count() > 0 || $check_siswa->count() > 0 || $check_no_telp->count() > 0){
                  $response['message'] = implode("\n",$message);
        } else {
            $orang_tua->user_id    = $request->input('user_id');
            $orang_tua->nomor_un = $request->input('nomor_un');
            $orang_tua->no_telp = $request->input('no_telp');
            $orang_tua->nama_ayah = $request->input('nama_ayah');
            $orang_tua->nama_ibu = $request->input('nama_ibu');
            $orang_tua->pendidikan_ayah = $request->input('pendidikan_ayah');
            $orang_tua->kerja_ayah = $request->input('kerja_ayah');
            $orang_tua->pendidikan_ibu = $request->input('pendidikan_ibu');
            $orang_tua->kerja_ibu = $request->input('kerja_ibu');
            $orang_tua->alamat_ortu = $request->input('alamat_ortu');
            $orang_tua->save();
            $response['message'] = 'success';
          }
        } else {
            $orang_tua->user_id    = $request->input('user_id');
            $orang_tua->nomor_un = $request->input('nomor_un');
            $orang_tua->no_telp = $request->input('no_telp');
            $orang_tua->nama_ayah = $request->input('nama_ayah');
            $orang_tua->nama_ibu = $request->input('nama_ibu');
            $orang_tua->pendidikan_ayah = $request->input('pendidikan_ayah');
            $orang_tua->kerja_ayah = $request->input('kerja_ayah');
            $orang_tua->pendidikan_ibu = $request->input('pendidikan_ibu');
            $orang_tua->kerja_ibu = $request->input('kerja_ibu');
            $orang_tua->alamat_ortu = $request->input('alamat_ortu');
            $orang_tua->save();
            $response['message'] = 'success';
        }
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrangTua  $orang_tua
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orang_tua = $this->orang_tua->findOrFail($id);
        if ($orang_tua->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
        return json_encode($response);
    }
}
