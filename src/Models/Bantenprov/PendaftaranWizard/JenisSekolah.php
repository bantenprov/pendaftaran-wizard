<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class JenisSekolah extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'jenis_sekolahs';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'jenis_sekolah',
        'user_id',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
        public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
