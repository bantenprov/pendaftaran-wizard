<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Pendaftaran extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'pendaftarans';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'kegiatan_id',
        'user_id',
        'tanggal_pendaftaran',
    ];
    public function kegiatan()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Kegiatan','kegiatan_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
