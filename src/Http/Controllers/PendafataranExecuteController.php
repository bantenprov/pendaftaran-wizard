<?php

namespace Bantenprov\PendaftaranWizard\Http\Controllers;
/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/* Models */
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Siswa;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Akademik;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Nilai;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\OrangTua;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Sekolah;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\ProdiSekolah;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Kegiatan;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Pendaftaran;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Prestasi;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\MasterPrestasi;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\MasterSktm;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Sktm;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use App\User;
use App\DataAkademik;

/* Workflow Trait */
use Bantenprov\VueWorkflow\Http\Traits\WorkflowTrait;

/* Etc */
use Carbon\Carbon;
use Validator;
use Auth;
/**
 * The SiswaController class.
 *
 * @package Bantenprov\Siswa
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PendafataranExecuteController extends Controller
{

    use WorkflowTrait;

    protected $sekolah;
    protected $prodiSekolah;
    protected $kegiatan;
    protected $siswa;
    protected $orangTua;
    protected $pendaftaran;
    protected $province;
    protected $city;
    protected $district;
    protected $village;
    protected $data_akademik;
    protected $nilai;
    protected $akademik;
    protected $master_prestasi;
    protected $prestasi;
    protected $master_sktm;
    protected $sktm;

    protected $tgl_pendaftaran;
    protected $current_user_id;
    protected $nomor_un;

    /**
     * PendafataranExecuteController constructor.
     * @param User $user
     * @param Sekolah $sekolah
     * @param ProdiSekolah $prodiSekolah
     * @param Kegiatan $kegiatan
     * @param Siswa $siswa
     * @param OrangTua $orangTua
     * @param Pendaftaran $pendaftaran
     * @param Province $province
     * @param City $city
     * @param District $district
     * @param Village $village
     */
    public function __construct(User $user, Sekolah $sekolah, ProdiSekolah $prodiSekolah, Kegiatan $kegiatan, Siswa $siswa, OrangTua $orangTua, Pendaftaran $pendaftaran, Province $province, City $city, District $district, Village $village, DataAkademik $data_akademik, Nilai $nilai, Akademik $akademik, MasterPrestasi $master_prestasi, Prestasi $prestasi, MasterSktm $master_sktm, Sktm $sktm)
    {
        $this->user             = $user;
        $this->sekolah          = $sekolah;
        $this->prodiSekolah     = $prodiSekolah;
        $this->kegiatan         = $kegiatan;
        $this->siswa            = $siswa;
        $this->orangTua         = $orangTua;
        $this->pendaftaran      = $pendaftaran;
        $this->province         = $province;
        $this->city             = $city;
        $this->district         = $district;
        $this->village          = $village;
        $this->data_akademik    = $data_akademik;
        $this->nilai            = $nilai;
        $this->akademik         = $akademik;
        $this->master_prestasi  = $master_prestasi;
        $this->prestasi         = $prestasi;
        $this->master_sktm      = $master_sktm;
        $this->sktm             = $sktm;

        $this->current_user_id  = Auth::User()->id;
        $this->nomor_un         = Auth::User()->name;

        $this->tgl_pendaftaran  = Carbon::now(new \DateTimeZone('Asia/Jakarta'));

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function execute(Request $request)
    {
        /* store pendaftaran */
        $pendaftaran_store['kegiatan_id']           = $request->input('kegiatan_id');
        $pendaftaran_store['user_id']               = $this->current_user_id;
        $pendaftaran_store['sekolah_id']            = $request->sekolah_id;
        $pendaftaran_store['tanggal_pendaftaran']   = $this->tgl_pendaftaran;
        $pendaftaran_store['nomor_un']              = $this->nomor_un;

        /* store siswa */
        $siswa_store['user_id']             = $this->current_user_id;
        $siswa_store['nomor_un']            = $this->nomor_un;
        // $siswa_store['nik']                 = $request->nik;
        $siswa_store['nama_siswa']          = $request->nama_siswa;
        $siswa_store['no_kk']               = $request->no_kk;
        $siswa_store['alamat_kk']           = $request->alamat_kk;
        $siswa_store['province_id']         = $request->province_id;
        $siswa_store['city_id']             = $request->city_id;
        $siswa_store['district_id']         = $request->district_id;
        $siswa_store['village_id']          = $request->village_id;
        $siswa_store['tempat_lahir']        = $request->tempat_lahir;
        $siswa_store['tgl_lahir']           = $request->tgl_lahir;
        $siswa_store['jenis_kelamin']       = $request->jenis_kelamin;
        $siswa_store['agama']               = $request->agama;
        $siswa_store['nisn']                = $request->nisn;
        $siswa_store['sekolah_id']          = $request->sekolah_id;
        if($request->input('kegiatan_id') == 12 || $request->input('kegiatan_id') == 11){
            $siswa_store['prodi_sekolah_id']      = '101';
        }else{
            $siswa_store['prodi_sekolah_id']      = $request->prodi_sekolah_id;
        }

        $siswa_store['tahun_lulus']         = $request->tahun_lulus;
        $siswa_store['kegiatan_id']         = $request->input('kegiatan_id');

        /* store orang tua */
        $orangTua_store['user_id']          = $this->current_user_id;
        $orangTua_store['nomor_un']         = $this->nomor_un;
        $orangTua_store['no_telp']          = $request->no_telp;
        $orangTua_store['nama_ayah']        = $request->nama_ayah;
        $orangTua_store['nama_ibu']         = $request->nama_ibu;
        $orangTua_store['pendidikan_ayah']  = $request->pendidikan_ayah;
        $orangTua_store['kerja_ayah']       = $request->kerja_ayah;
        $orangTua_store['pendidikan_ibu']   = $request->pendidikan_ibu;
        $orangTua_store['kerja_ibu']        = $request->kerja_ibu;
        $orangTua_store['alamat_ortu']      = $request->alamat_ortu;

        /* store prestasi */
        $prestasi_store['nomor_un']             = $this->nomor_un;
        $prestasi_store['master_prestasi_id']   = $request->master_prestasi_id;
        $prestasi_store['nama_lomba']           = $request->nama_lomba;



        $pendaftaran    = $this->storePendaftaran($pendaftaran_store);
        $siswa          = $this->storeSiswa($siswa_store, $request->input('kegiatan_id'));
        $orangTua       = $this->storeOrangTua($orangTua_store);
        if($request->input('kegiatan_id') ==  11 || $request->input('kegiatan_id') == 21){
            $prestasi       = $this->storePrestasi($prestasi_store);
        }else{
            $prestasi['error'] = false;
        }



        if($pendaftaran['error']){
            return response()->json($pendaftaran);
        }elseif($siswa['error']){
            return response()->json($siswa);
        }elseif($orangTua['error']){
            return response()->json($orangTua);
        }elseif($prestasi['error']){
            return response()->json($prestasi);
        }else{
            /* pendaftaran */
            // $this->insertWithWorkflow($this->pendaftaran, $pendaftaran_store);

            /* siswa */
            $this->siswa->nomor_un            = $this->nomor_un;
            $this->siswa->nik                 = 99999999;
            $this->siswa->nama_siswa          = $request->nama_siswa;
            $this->siswa->no_kk               = $request->no_kk;
            $this->siswa->alamat_kk           = $request->alamat_kk;
            $this->siswa->province_id         = $request->province_id;
            $this->siswa->city_id             = $request->city_id;
            $this->siswa->district_id         = $request->district_id;
            $this->siswa->village_id          = $request->village_id;
            $this->siswa->tempat_lahir        = $request->tempat_lahir;
            $this->siswa->tgl_lahir           = $request->tgl_lahir;
            $this->siswa->jenis_kelamin       = $request->jenis_kelamin;
            $this->siswa->agama               = $request->agama;
            $this->siswa->nisn                = $request->nisn;
            $this->siswa->sekolah_id          = $request->sekolah_id;
            $this->siswa->prodi_sekolah_id    = $request->prodi_sekolah_id;
            $this->siswa->tahun_lulus         = $request->tahun_lulus;
            $this->siswa->user_id             = $this->current_user_id;
            if($request->input('kegiatan_id') == 12 || $request->input('kegiatan_id') == 11){
                $this->siswa->prodi_sekolah_id      = '101';
            }else{
                $this->siswa->prodi_sekolah_id     = $request->prodi_sekolah_id;
            }
            $this->siswa->kegiatan_id         = $request->kegiatan_id;
            // $this->siswa->save();

            /* orang tua */
            $this->orangTua->user_id         = $this->current_user_id;
            $this->orangTua->nomor_un        = $this->nomor_un;
            $this->orangTua->no_telp         = $request->no_telp;
            $this->orangTua->nama_ayah       = $request->nama_ayah;
            $this->orangTua->nama_ibu        = $request->nama_ibu;
            $this->orangTua->pendidikan_ayah = $request->pendidikan_ayah;
            $this->orangTua->kerja_ayah      = $request->kerja_ayah;
            $this->orangTua->pendidikan_ibu  = $request->pendidikan_ibu;
            $this->orangTua->kerja_ibu       = $request->kerja_ibu;
            $this->orangTua->alamat_ortu     = $request->alamat_ortu;
            // $this->orangTua->save();

            /* akademik */
            $data_akademik = $this->data_akademik->where('nomor_un', $this->nomor_un)->first();
            $this->akademik->nomor_un         = $this->nomor_un;
            $this->akademik->bahasa_indonesia = $data_akademik->bahasa_indonesia;
            $this->akademik->bahasa_inggris   = $data_akademik->bahasa_inggris;
            $this->akademik->matematika       = $data_akademik->matematika;
            $this->akademik->ipa              = $data_akademik->ipa;
            $this->akademik->user_id          = $this->current_user_id;
            // $this->akademik->save();

            /* prestasi */
            if($request->input('kegiatan_id') ==  11 || $request->input('kegiatan_id') == 21){
                $master_prestasi                      = $this->master_prestasi->findOrFail($request->master_prestasi_id);
                $this->prestasi->nomor_un             = $this->nomor_un;
                $this->prestasi->master_prestasi_id   = $request->master_prestasi_id;
                $this->prestasi->nama_lomba           = $request->nama_lomba;
                $this->prestasi->nilai                = $master_prestasi->nilai;
                $this->prestasi->user_id              = $this->current_user_id;
            }

            /* sktm */
            if($request->master_sktm_id != "" && $request->no_sktm != ""){
                $sktm_master_sktm_id          = $request->master_sktm_id;
                $master_sktm                  = $this->master_sktm->findOrFail($sktm_master_sktm_id);
                $this->sktm->nomor_un         = $this->nomor_un;
                $this->sktm->master_sktm_id   = $sktm_master_sktm_id;
                $this->sktm->no_sktm          = $request->input('no_sktm');
                $this->sktm->nilai            = $master_sktm->nilai;
                $this->sktm->user_id          = $this->current_user_id;
            }



            $nilai1 = $this->nilai->updateOrCreate(
                [
                    'nomor_un'  => $this->nomor_un,
                ],
                [
                    'nomor_un'  => $this->akademik->nomor_un,
                    'bobot'     => $this->akademik->calcNilaiBobot(array(
                        'bahasa_indonesia' => $data_akademik->bahasa_indonesia,
                        'bahasa_inggris' => $data_akademik->bahasa_inggris,
                        'matematika' => $data_akademik->matematika,
                        'ipa' => $data_akademik->ipa,
                    )),
                    'akademik'  => $this->akademik->calcNilaiAkademik(array(
                        'bahasa_indonesia' => $data_akademik->bahasa_indonesia,
                        'bahasa_inggris' => $data_akademik->bahasa_inggris,
                        'matematika' => $data_akademik->matematika,
                        'ipa' => $data_akademik->ipa,
                    )),
                    'kegiatan_id' => $request->input('kegiatan_id'),
                    'total'     => null,
                    'user_id'   => $this->current_user_id,
                ]
            );

            if($request->input('kegiatan_id') ==  11 || $request->input('kegiatan_id') == 21){
                $nilai2 = $this->nilai->updateOrCreate(
                    [
                        'nomor_un'  => $this->nomor_un,
                    ],
                    [
                        'prestasi'      => $this->prestasi->nilai,
                        'user_id'       => $this->current_user_id,
                    ]
                );
            }

            if($request->master_sktm_id != "" && $request->no_sktm != ""){
                $nilai3 = $this->nilai->updateOrCreate(
                    [
                        'nomor_un'  => $this->sktm->nomor_un,
                    ],
                    [
                        'sktm'          => $this->sktm->nilai,
                        'user_id'       => $this->current_user_id,
                    ]
                );
            }

            DB::beginTransaction();
            if($request->input('kegiatan_id') ==  11 || $request->input('kegiatan_id') == 21){
                if($request->master_sktm_id != "" && $request->no_sktm != ""){
                    if ($this->akademik->save() && $nilai1->save() && $nilai2->save() && $this->orangTua->save() && $this->siswa->save() && $this->prestasi->save() && $this->sktm->save() && $nilai3->save())
                    {
                        DB::commit();

                        $this->insertWithWorkflow($this->pendaftaran, $pendaftaran_store);

                        $error      = false;
                        // $message    = 'Success';
                    } else {
                        DB::rollBack();
                        $error      = true;
                        // $message    = 'Failed';
                    }
                }else{
                    if ($this->akademik->save() && $nilai1->save() && $nilai2->save() && $this->orangTua->save() && $this->siswa->save() && $this->prestasi->save())
                    {
                        DB::commit();

                        $this->insertWithWorkflow($this->pendaftaran, $pendaftaran_store);

                        $error      = false;
                        // $message    = 'Success';
                    } else {
                        DB::rollBack();
                        $error      = true;
                        // $message    = 'Failed';
                    }
                }

            }else{
                if($request->master_sktm_id != "" && $request->no_sktm != ""){
                    if ($this->akademik->save() && $nilai1->save() &&  $this->orangTua->save() && $this->siswa->save() && $nilai3->save() && $this->sktm->save())
                    {
                        DB::commit();

                        $this->insertWithWorkflow($this->pendaftaran, $pendaftaran_store);

                        $error      = false;
                        // $message    = 'Success';
                    } else {
                        DB::rollBack();
                        $error      = true;
                        // $message    = 'Failed';
                    }
                }else{
                    if ($this->akademik->save() && $nilai1->save() &&  $this->orangTua->save() && $this->siswa->save())
                    {
                        DB::commit();

                        $this->insertWithWorkflow($this->pendaftaran, $pendaftaran_store);

                        $error      = false;
                        // $message    = 'Success';
                    } else {
                        DB::rollBack();
                        $error      = true;
                        // $message    = 'Failed';
                    }
                }

            }


        }

        $response['status']     = true;
        $response['error']      = $error;
        $response['type']       = "success";
        $response['title']      = "Pendaftaran Berhasil";
        $response['message']    = "Nomor UN : {$this->nomor_un} berhasil di daftarkan";

        return response()->json($response);
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function storePendaftaran($request = array()){

        $pendaftaran = $this->pendaftaran;

        $validator = Validator::make($request, [
            'kegiatan_id' => 'required',
            'user_id' => 'required|max:16|unique:pendaftarans,user_id',
            'tanggal_pendaftaran' => 'required',
        ]);

        if($validator->fails()){
            $check = $pendaftaran->where('user_id', $this->current_user_id)->whereNull('deleted_at')->count();
            if ($check > 0) {
                $response['error']      = true;
                $response['type']       = "error";
                $response['title']      = "Pendaftaran Gagal";
                $response['message']    = "Nomor UN ini {$this->nomor_un} telah terdaftar.";
            } else {
                $response['error']      = false;
                $response['type']       = "success";
                $response['title']      = "Pendaftaran Berhasil";
                $response['message']    = "Nomor UN ini {$this->nomor_un} berhasil di daftarkan.";
            }
        } else {
            $response['error']      = false;
            $response['type']       = "success";
            $response['tittle']     = "Pendaftaran Berhasil";
            $response['message']    = "Nomor UN ini {$this->nomor_un} berhasil di daftarkan";
        }

        $response['status']     = true;

        return $response;
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function storeSiswa($request = array(), $jenis_pendaftaran)
    {
        $siswa      = $this->siswa;

        if($jenis_pendaftaran == 11 || $jenis_pendaftaran == 12){
            $validator  = Validator::make($request, [
                'nomor_un'          => "max:255|unique:{$this->siswa->getTable()},nomor_un,NULL,id,deleted_at,NULL",
                // 'nik'               => "required|digits_between:5,20|unique:{$this->siswa->getTable()},nik,NULL,id,deleted_at,NULL",
                'nama_siswa'        => 'required|max:255',
                'no_kk'             => "required|digits_between:5,20|unique:{$this->siswa->getTable()},no_kk,NULL,id,deleted_at,NULL",
                'alamat_kk'         => 'required|max:255',
                'province_id'       => "required|exists:{$this->province->getTable()},id",
                'city_id'           => "required|exists:{$this->city->getTable()},id",
                'district_id'       => "required|exists:{$this->district->getTable()},id",
                'village_id'        => "required|exists:{$this->village->getTable()},id",
                'tempat_lahir'      => 'required|max:255',
                'tgl_lahir'         => 'required|date',
                'jenis_kelamin'     => 'required|max:255',
                'agama'             => 'required|max:255',
                'nisn'              => 'required',
                'tahun_lulus'       => 'required|date_format:Y',
                'sekolah_id'        => "required|exists:{$this->sekolah->getTable()},id",
                'user_id'           => "required|exists:{$this->user->getTable()},id",
            ]);
        }elseif($jenis_pendaftaran == 21 || $jenis_pendaftaran == 22){
            $validator  = Validator::make($request, [
                'nomor_un'          => "max:255|unique:{$this->siswa->getTable()},nomor_un,NULL,id,deleted_at,NULL",
                // 'nik'               => "required|digits_between:5,20|unique:{$this->siswa->getTable()},nik,NULL,id,deleted_at,NULL",
                'nama_siswa'        => 'required|max:255',
                'no_kk'             => "required|digits_between:5,20|unique:{$this->siswa->getTable()},no_kk,NULL,id,deleted_at,NULL",
                'alamat_kk'         => 'required|max:255',
                'province_id'       => "required|exists:{$this->province->getTable()},id",
                'city_id'           => "required|exists:{$this->city->getTable()},id",
                'district_id'       => "required|exists:{$this->district->getTable()},id",
                'village_id'        => "required|exists:{$this->village->getTable()},id",
                'tempat_lahir'      => 'required|max:255',
                'tgl_lahir'         => 'required|date',
                'jenis_kelamin'     => 'required|max:255',
                'agama'             => 'required|max:255',
                'nisn'              => 'required',
                'tahun_lulus'       => 'required|date_format:Y',
                'sekolah_id'        => "required|exists:{$this->sekolah->getTable()},id",
                'prodi_sekolah_id'  => "required|exists:{$this->prodiSekolah->getTable()},id",
                'user_id'           => "required|exists:{$this->user->getTable()},id",
            ]);
        }

        // $validator  = Validator::make($request, [
        //     'nomor_un'          => "max:255|unique:{$this->siswa->getTable()},nomor_un,NULL,id,deleted_at,NULL",
        //     'nik'               => "required|digits_between:5,20|unique:{$this->siswa->getTable()},nik,NULL,id,deleted_at,NULL",
        //     'nama_siswa'        => 'required|max:255',
        //     'no_kk'             => "required|digits_between:5,20|unique:{$this->siswa->getTable()},no_kk,NULL,id,deleted_at,NULL",
        //     'alamat_kk'         => 'required|max:255',
        //     'province_id'       => "required|exists:{$this->province->getTable()},id",
        //     'city_id'           => "required|exists:{$this->city->getTable()},id",
        //     'district_id'       => "required|exists:{$this->district->getTable()},id",
        //     'village_id'        => "required|exists:{$this->village->getTable()},id",
        //     'tempat_lahir'      => 'required|max:255',
        //     'tgl_lahir'         => 'required|date',
        //     'jenis_kelamin'     => 'required|max:255',
        //     'agama'             => 'required|max:255',
        //     'nisn'              => 'required',
        //     'tahun_lulus'       => 'required|date_format:Y',
        //     'sekolah_id'        => "required|exists:{$this->sekolah->getTable()},id",
        //     'prodi_sekolah_id'  => "required|exists:{$this->prodiSekolah->getTable()},id",
        //     'user_id'           => "required|exists:{$this->user->getTable()},id",
        // ]);
        if ($validator->fails()) {
            $error      = true;
            $type       = 'error';
            $title      = 'Pendaftaran Gagal';
            $message    = $validator->errors()->first();
        } else {
            $error      = false;
            $type       = 'success';
            $title      = 'Pendaftaran Berhasil';
            $message    = 'Success';
        }
        $response['type']       = $type;
        $response['title']      = $title;
        $response['siswa']      = $siswa;
        $response['error']      = $error;
        $response['message']    = $message;
        $response['status']     = true;

        return $response;
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function storeOrangTua($request = array())
    {
        $orang_tua = $this->orangTua;
        $validator = Validator::make($request, [
            'user_id' => 'required|unique:orangtuas,user_id',
            'nomor_un' => 'unique:orangtuas,nomor_un',
            'no_telp'   => 'required|digits_between:5,20',
            'nama_ayah'   => 'required',
            'nama_ibu'   => 'required',
            'pendidikan_ayah'   => 'required',
            'kerja_ayah'   => 'required',
            'pendidikan_ibu'   => 'required',
            'kerja_ibu'   => 'required',
            'alamat_ortu'   => 'required',
        ]);
        if($validator->fails()){
            $check = $orang_tua->where('user_id',$this->current_user_id)->orWhere('nomor_un',$this->nomor_un)->whereNull('deleted_at')->count();
            if ($check > 0) {
                $response['error']      = true;
                $response['type']       = "error";
                $response['title']      = "Pendaftaran Gagal";
                $response['message']    = "Nomor UN ini {$this->nomor_un} telah terdaftar.";
            } else {

                $response['error']          = false;
            }

            $response['error']      = true;
            $response['type']       = "error";
            $response['title']      = "Pendaftaran Gagal";
            $response['message']    = $validator->errors()->first();
        } else {
            $response['error']      = false;
        }

        $response['status'] = true;

        return $response;
    }

    public function storePrestasi($request = array())
    {
        $prestasi = $this->prestasi;
        $validator = Validator::make($request, [
            'nomor_un'              => "required|unique:{$this->prestasi->getTable()},nomor_un,NULL,id,deleted_at,NULL",
            'master_prestasi_id'    => "required|exists:{$this->master_prestasi->getTable()},id",
            'nama_lomba'            => 'required|max:255',
            // 'nilai'             => 'required|numeric|min:0|max:100',
        ]);
        if ($validator->fails()) {
            $response['error']      = true;
            $response['type']       = "error";
            $response['title']      = "Pendaftaran Gagal";
            $response['message']    = $validator->errors()->first();
        } else {
            $response['error']      = false;
        }
        $response['status'] = true;
        return $response;
    }

    public function storeSktm($request = array())
    {
        $sktm = $this->sktm;
        $validator = Validator::make($request, [
            'nomor_un'          => "required|unique:{$this->sktm->getTable()},nomor_un,NULL,id,deleted_at,NULL",
            'master_sktm_id'    => "required|exists:{$this->master_sktm->getTable()},id",
            'no_sktm'           => 'required|max:255',
        ]);
        if ($validator->fails()) {
            $response['error']      = true;
            $response['type']       = "error";
            $response['title']      = "Pendaftaran Gagal";
            $response['message']    = $validator->errors()->first();
        } else {
            $response['error']      = false;
        }

        $response['status']     = true;
        return response()->json($response);
    }

}
