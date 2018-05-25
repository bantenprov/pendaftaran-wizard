<?php
namespace Bantenprov\PendaftaranWizard\Http\Controllers;
/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/* Models */
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Prestasi;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\MasterPrestasi;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Siswa;
use App\User;
use Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Nilai;
/* Etc */
use Validator;
use Auth;
/**
 * The PrestasiController class.
 *
 * @package Bantenprov\Prestasi
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PrestasiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $prestasi;
    protected $siswa;
    protected $master_prestasi;
    protected $user;
    protected $nilai;
    protected $admin_sekolah;
    public function __construct()
    {
        $this->prestasi         = new Prestasi;
        $this->siswa            = new Siswa;
        $this->master_prestasi  = new MasterPrestasi;
        $this->user             = new User;
        $this->nilai            = new Nilai;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $response = [];
        $master_prestasis = $this->master_prestasi->all();


        foreach($master_prestasis as $master_prestasi){
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
        }


        $response['master_prestasi'] = $master_prestasis;
        $response['status'] = true;
        return response()->json($response);
    }
}
