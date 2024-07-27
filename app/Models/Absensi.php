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

    // Menghitung total jam kerja
    public function getTotalHoursAttribute(): float
    {
        if ($this->mulai_kerja && $this->akhir_kerja) {
            $mulaiKerja = \Carbon\Carbon::parse($this->mulai_kerja);
            $akhirKerja = \Carbon\Carbon::parse($this->akhir_kerja);
            return $akhirKerja->diffInHours($mulaiKerja) + ($akhirKerja->diffInMinutes($mulaiKerja) % 60) / 60;
        }
        return 0;
    }
    
}
