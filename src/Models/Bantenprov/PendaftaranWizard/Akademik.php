<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Akademik extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'akademiks';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'nomor_un',
        'bahasa_indonesia',
        'bahasa_inggris',
        'matematika',
        'ipa',
        'user_id',
    ];
    public function siswa()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Siswa','nomor_un','nomor_un');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function calcNilaiBobot($request = array())
    {
        /*

        'bahasa_indonesia' => 0.6,
        'bahasa_inggris' => 0.2,
        'matematika' => 0.1,
        'ipa' => 0.1,
        */
        $bahasa_indonesia   = $request['bahasa_indonesia'] * 0.6;
        $bahasa_inggris     = $request['bahasa_inggris'] * 0.2;
        $matematika         = $request['matematika'] * 0.1;
        $ipa                = $request['ipa'] * 0.1;
        return $bahasa_indonesia + $bahasa_inggris + $matematika + $ipa;
    }
    public function calcNilaiAkademik($request = array())
    {
        $bahasa_indonesia   = $request['bahasa_indonesia'];
        $bahasa_inggris     = $request['bahasa_inggris'];
        $matematika         = $request['matematika'];
        $ipa                = $request['ipa'];
        return $bahasa_indonesia + $bahasa_inggris + $matematika + $ipa;
    }
}
