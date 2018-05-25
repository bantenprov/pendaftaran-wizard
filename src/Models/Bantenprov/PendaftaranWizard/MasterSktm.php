<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MasterSktm extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'master_sktms';
    protected $fillable = [
        'nama',
        'instansi',
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
        return $this->nama;
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
 }
