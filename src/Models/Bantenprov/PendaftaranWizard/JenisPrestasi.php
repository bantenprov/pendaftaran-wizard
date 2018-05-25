<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class JenisPrestasi extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'jenis_prestasis';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'user_id',
        'nama'
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
