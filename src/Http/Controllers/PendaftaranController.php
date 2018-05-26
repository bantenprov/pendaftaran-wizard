<?php
namespace Bantenprov\PendaftaranWizard\Http\Controllers;
/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
/* Models */
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Pendaftaran;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Kegiatan;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Siswa;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\OrangTua;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Prestasi;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\MasterPrestasi;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\MasterSktm;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Sktm;
use Bantenprov\VueWorkflow\Models\History;
use Bantenprov\VueWorkflow\Models\State;
use App\DataAkademik;
use App\User;
/* Etc */
use Validator;
use Auth;

/* Workflow Trait */
use Bantenprov\VueWorkflow\Http\Traits\WorkflowTrait;

/**
 * The PendaftaranController class.
 *
 * @package Bantenprov\Pendaftaran
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */

class PendaftaranController extends Controller
{
    use WorkflowTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $kegiatanModel;
    protected $pendaftaran;
    protected $siswa;
    protected $orang_tua;
    protected $user;
    protected $data_akademik;
    protected $prestasi;
    protected $master_prestasi;
    protected $sktm;
    protected $master_sktm;

    public function __construct(Pendaftaran $pendaftaran, Kegiatan $kegiatan, User $user, Siswa $siswa, OrangTua $orang_tua, DataAkademik $data_akademik, History $history, State $state, Prestasi $prestasi, MasterPrestasi $master_prestasi, MasterSktm $master_sktm, Sktm $sktm)
    {
        $this->pendaftaran      = $pendaftaran;
        $this->kegiatanModel    = $kegiatan;
        $this->siswa            = $siswa;
        $this->orang_tua        = $orang_tua;
        $this->user             = $user;
        $this->data_akademik    = $data_akademik;
        $this->history          = $history;
        $this->state            = $state;
        $this->prestasi         = $prestasi;
        $this->master_prestasi  = $master_prestasi;
        $this->sktm             = $sktm;
        $this->master_sktm      = $master_sktm;
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
            $query = $this->pendaftaran->with('kegiatan')->with('user')->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->pendaftaran->with('kegiatan')->with('user')->orderBy('id', 'asc');
        }
        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('tanggal_pendaftaran', 'like', $value)
                    ->orWhere('tanggal_pendaftaran', 'like', $value);
            });
        }
        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->paginate($perPage);
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
        $response       = [];
        $kegiatan       = $this->kegiatanModel->all();
        $users_special  = $this->user->all();
        $users_standar  = $this->user->find(\Auth::User()->id);
        $check_daftar   = $this->pendaftaran->where('user_id', \Auth::user()->id)->count();
        $current_user   = \Auth::User();
        $role_check     = \Auth::User()->hasRole(['superadministrator','administrator']);
        if($role_check){
            $response['user_special'] = true;
            foreach($users_special as $user){
                array_set($user, 'label', $user->name);
            }
            $response['user'] = $users_special;
        }else{
            $response['user_special']   = false;
            array_set($users_standar, 'label', $users_standar->name);
            $response['user']           = $users_standar;
        }
        array_set($current_user, 'label', $current_user->name);

        if($check_daftar > 0 ){
            $prestasi_data = $this->prestasi->where('nomor_un', $current_user->name)->first();
            $response['data_terdaftar']    = $this->getDataTerdaftar();
            $response['data_terdaftar']    = $this->getDataTerdaftar();
            $response['prestasi']          = $this->getMasterPrestasi($prestasi_data->master_prestasi_id);
            $response['sktm']              = $this->getSktm($current_user->name);
            $response['nama_lomba']        = $prestasi_data->nama_lomba;
        }


        $response['terdaftar']      = ($check_daftar > 0) ? true : false;
        $response['current_user']   = $current_user;
        $response['kegiatan']       = $kegiatan;
        $response['status']         = true;
        return response()->json($response);
    }

    public function getMasterPrestasi($id)
    {
        $response = [];
        $master_prestasi = $this->master_prestasi->find($id);



            if($master_prestasi->juara == 1){
                $juara = "Juara 1";
            }elseif($master_prestasi->juara == 2){
                $juara = "Juara 2";
            }elseif($master_prestasi->juara == 3){
                $juara = "Juara 3";
            }else{
                $juara = "Juara Harapan 1";
            }
            if($master_prestasi->tingkat == 1){
                $tingkat = "Tingkat Internasional";
            }elseif($master_prestasi->tingkat == 2){
                $tingkat = "Tingkat Nasional";
            }elseif($master_prestasi->tingkat == 3){
                $tingkat = "Tingkat Provinsi";
            }else{
                $tingkat = "Tingkat Kabupaten/Kota";
            }
            array_set($master_prestasi, 'label', "( ".$juara." ".$tingkat." ) - ".$master_prestasi->jenis_prestasi->nama);



        $response['master_prestasi'] = $master_prestasi;
        return $response;
    }

    public function getSktm($id)
    {
        $response       = [];
        $sktm           = $this->sktm->with(['master_sktm'])->where('nomor_un', $id)->first();


        $response['sktm'] = $sktm;
        return $response;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tgl_pendaftaran = Carbon::now(new \DateTimeZone('Asia/Jakarta'));
        $pendaftaran = $this->pendaftaran;
        $current_user_id = Auth::User()->id;
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required',
            'user_id' => 'required|max:16|unique:pendaftarans,user_id',
            'tanggal_pendaftaran' => 'required',
        ]);
        if($validator->fails()){
            $check = $pendaftaran->where('user_id', $current_user_id)->whereNull('deleted_at')->count();
            if ($check > 0) {
                $response['message'] = 'Failed, User already exists';
            } else {

                /* $pendaftaran->kegiatan_id = $request->input('kegiatan_id');
                $pendaftaran->user_id = $current_user_id;
                $pendaftaran->tanggal_pendaftaran = $tgl_pendaftaran;
                $pendaftaran->save(); */

                $pendaftaran_save['kegiatan_id'] = $request->input('kegiatan_id');
                $pendaftaran_save['user_id'] = $current_user_id;
                $pendaftaran_save['tanggal_pendaftaran'] = $tgl_pendaftaran;

                $this->insertWithWorkflow($pendaftaran, $pendaftaran_save);

                $response['message'] = 'success';
            }
        } else {
            /* $pendaftaran->kegiatan_id = $request->input('kegiatan_id');
            $pendaftaran->user_id = $current_user_id;
            $pendaftaran->tanggal_pendaftaran = $tgl_pendaftaran;
            $pendaftaran->save(); */

            $pendaftaran_save['kegiatan_id'] = $request->input('kegiatan_id');
            $pendaftaran_save['user_id'] = $current_user_id;
            $pendaftaran_save['tanggal_pendaftaran'] = $tgl_pendaftaran;

            $this->insertWithWorkflow($pendaftaran, $pendaftaran_save);

            $response['message'] = 'success';
        }
        $response['status'] = true;
        return response()->json($response);
    }

    public function getDataTerdaftar(){
        $pendaftaran = $this->pendaftaran;
        // $siswa       = $this->siswa;
        $orang_tua   = $this->orang_tua;

        $response['pendaftaran']    = $this->pendaftaran->where('user_id', \Auth::user()->id)->with('kegiatan')->first();

        $siswa = $this->siswa->with(['province', 'city', 'district', 'village', 'sekolah', 'prodi_sekolah', 'user'])->where('nomor_un',  \Auth::user()->name)->first();

        if (isset($siswa->prodi_sekolah->program_keahlian)) {
            $siswa->prodi_sekolah->program_keahlian;
        }

        $response['orang_tua'] = $orang_tua->where('nomor_un', \Auth::user()->name)->first();

        array_add($siswa->sekolah, 'label', $siswa->sekolah->nama);
        array_add($siswa->province, 'label', $siswa->province->name);
        array_add($siswa->city, 'label', $siswa->city->name);
        array_add($siswa->district, 'label', $siswa->district->name);
        array_add($siswa->village, 'label', $siswa->village->name);


        $response['siswa']      = $siswa;

        $response['nilai_un']   = $this->data_akademik->where('nomor_un',\Auth::user()->name)->first();

        $history_first = $this->history->where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->first();

        $history = $this->history->where('content_id', $history_first->content_id)->orderBy('id', 'desc')->first();

        $status_now = '';

        if($this->state->find($history->to_state)->label == "Propose"){
            $status_now = "Terdaftar";
        }else{
            $status_now = $this->state->find($history->to_state)->label;
        }

        $response['status_now'] = $status_now;


        return $response;

        // $response['siswa']    = $this->siswa->where('user_id', \Auth::user()->id)->first();
    }

    public function checkPeserta($nomor_un){
        $pendaftaran = $this->pendaftaran;
        // $siswa       = $this->siswa;
        $orang_tua   = $this->orang_tua;

        // $response['pendaftaran']    = $this->pendaftaran->where('user_id', \Auth::user()->id)->with('kegiatan')->first();

        $siswa = $this->siswa->with(['province', 'city', 'district', 'village', 'sekolah', 'prodi_sekolah', 'user'])->where('nomor_un',  $nomor_un)->first();

        if (isset($siswa->prodi_sekolah->program_keahlian)) {
            $siswa->prodi_sekolah->program_keahlian;
        }

        $response['orang_tua'] = $orang_tua->where('nomor_un', $nomor_un)->first();

        array_add($siswa->sekolah, 'label', $siswa->sekolah->nama);
        array_add($siswa->province, 'label', $siswa->province->name);
        array_add($siswa->city, 'label', $siswa->city->name);
        array_add($siswa->district, 'label', $siswa->district->name);
        array_add($siswa->village, 'label', $siswa->village->name);


        $response['siswa']      = $siswa;

        $response['nilai_un']   = $this->data_akademik->where('nomor_un',$nomor_un)->first();

        $history = $this->history->where('user_id', $siswa->user_id)->orderBy('id', 'desc')->first();

        $status_now = '';
        if($this->state->find($history->to_state)->label == "Propose"){
            $status_now = "Terdaftar";
        }

        $response['status_now'] = $status_now;


        return $response;

        // $response['siswa']    = $this->siswa->where('user_id', \Auth::user()->id)->first();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pendaftaran = $this->pendaftaran->findOrFail($id);
        $response['pendaftaran'] = $pendaftaran;
        $response['kegiatan'] = $pendaftaran->kegiatan;
        $response['user'] = $pendaftaran->user;
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pendaftaran = $this->pendaftaran->findOrFail($id);
        array_set($pendaftaran->user, 'label', $pendaftaran->user->name);
        $response['pendaftaran'] = $pendaftaran;
        $response['kegiatan'] = $pendaftaran->kegiatan;
        $response['user'] = $pendaftaran->user;
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pendaftaran = $this->pendaftaran->findOrFail($id);
        if ($request->input('old_user_id') == $request->input('user_id'))
        {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'kegiatan_id' => 'required',
                'tanggal_pendaftaran' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:pendaftarans,user_id',
                'kegiatan_id' => 'required',
                'tanggal_pendaftaran' => 'required',
            ]);
        }
        if ($validator->fails()) {
            $check = $pendaftaran->where('user_id',$request->user_id)->whereNull('deleted_at')->count();
            if ($check > 0) {
                $response['message'] = 'Failed, username ' . $request->user_id . ' already exists';
            } else {
                $pendaftaran->user_id = $request->input('user_id');
                $pendaftaran->kegiatan_id = $request->input('kegiatan_id');
                $pendaftaran->tanggal_pendaftaran = $request->input('tanggal_pendaftaran');
                $pendaftaran->save();
                $response['message'] = 'success';
            }
        } else {
            $pendaftaran->user_id = $request->input('user_id');
                $pendaftaran->kegiatan_id = $request->input('kegiatan_id');
                $pendaftaran->tanggal_pendaftaran = $request->input('tanggal_pendaftaran');
                $pendaftaran->save();
            $response['message'] = 'success';
        }
        $response['status'] = true;
        return response()->json($response);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pendaftaran  $pendaftaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pendaftaran = $this->pendaftaran->findOrFail($id);
        if ($pendaftaran->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
        return json_encode($response);
    }
}
