<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Prestasi extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'prestasis';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'user_id',
        'master_prestasi_id',
        'nomor_un',
        'nama_lomba'
    ];
    public function master_prestasi()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\MasterPrestasi','master_prestasi_id');
    }
    public function siswa()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Siswa','nomor_un','nomor_un');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
