<?php
namespace Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard;
use Illuminate\Database\Eloquent\Model;
/**
 * The OrangTua class.
 *
 * @package Bantenprov\OrangTua
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class OrangTua extends Model
{

    protected $table = 'orangtuas';

    protected $fillable = [
        'nomor_un',
        'alamat_ortu',
        'nama_ayah',
        'nama_ibu',
        'kerja_ayah',
        'pendidikan_ayah',
        'kerja_ibu',
        'pendidikan_ibu',
        'no_telp',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function siswa()
    {
        return $this->belongsTo('Bantenprov\PendaftaranWizard\Models\Bantenprov\PendaftaranWizard\Siswa','nomor_un','nomor_un');
    }
}
