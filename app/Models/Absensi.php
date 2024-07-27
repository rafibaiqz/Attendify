<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'mulai_kerja',
        'akhir_kerja',
    ];

    /**
     * Get the total hours worked.
     *
     * @return float
     */
    public function getTotalHoursAttribute(): float
    {
        $mulaiKerja = Carbon::parse($this->mulai_kerja);
        $akhirKerja = Carbon::parse($this->akhir_kerja);
        return $akhirKerja->diffInHours($mulaiKerja) + ($akhirKerja->diffInMinutes($mulaiKerja) % 60) / 60;
    }
}
