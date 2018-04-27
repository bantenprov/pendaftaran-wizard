<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProgramKeahlian extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'program_keahlians';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'label',
        'keterangan',
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