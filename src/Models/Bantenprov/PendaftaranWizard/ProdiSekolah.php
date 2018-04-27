<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProdiSekolah extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'prodi_sekolahs';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'sekolah_id',
        'program_keahlian_id',
        'kuota_siswa',
        'keterangan',
        'user_id',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    public function sekolah()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Sekolah','sekolah_id');
    }
    public function program_keahlian()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\ProgramKeahlian','program_keahlian_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
