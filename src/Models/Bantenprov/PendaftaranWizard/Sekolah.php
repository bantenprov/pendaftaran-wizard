<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Sekolah extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'sekolahs';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'nama',
        'npsn',
        'jenis_sekolah_id',
        'alamat',
        'logo',
        'foto_gedung',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'no_telp',
        'email',
        'kode_zona',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function jenis_sekolah()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\JenisSekolah','jenis_sekolah_id');
    }
    public function province()
    {
        return $this->belongsTo('Laravolt\Indonesia\Models\Province','province_id');
    }
    public function city()
    {
        return $this->belongsTo('Laravolt\Indonesia\Models\City','city_id');
    }
    public function district()
    {
        return $this->belongsTo('Laravolt\Indonesia\Models\District','district_id');
    }
    public function village()
    {
        return $this->belongsTo('Laravolt\Indonesia\Models\Village','village_id');
    }
    public function master_zona()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\MasterZona','kode_zona');
    }
}
