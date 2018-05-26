<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Zona extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'zonas';
    protected $fillable = [
        'nomor_un',
        'sekolah_id',
        'zona_siswa',
        'zona_sekolah',
        'lokasi_siswa',
        'lokasi_sekolah',
        'nilai',
        'user_id',
    ];
    protected $hidden = [
    ];
    protected $appends = [
        'label',
    ];
    protected $dates = [
        'deleted_at',
    ];
    public function getLabelAttribute()
    {
        if ($this->siswa !== null) {
            return $this->siswa->nomor_un.' - '.$this->siswa->nama_siswa;
        } else {
            return $this->nomor_un.' - ';
        }
    }
    public function siswa()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Siswa', 'nomor_un', 'nomor_un');
    }
    public function sekolah()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Sekolah', 'sekolah_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function nilai($lokasi_siswa, $lokasi_sekolah)
    {
        $nilai = 0;
        if ($lokasi_siswa == $lokasi_sekolah) {
            $nilai  = $nilai + 50;
        }
        if (substr($lokasi_siswa, 0, 6) == substr($lokasi_sekolah, 0, 6)) {
            $nilai  = $nilai + 50;
        }
        return $nilai;
    }
}
