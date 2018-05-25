<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MasterPrestasi extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'master_prestasis';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'jenis_prestasi_id',
        'juara',
        'tingkat',
        'nilai',
        'kode',
        'user_id'
    ];
    public function jenis_prestasi()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\JenisPrestasi','jenis_prestasi_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
