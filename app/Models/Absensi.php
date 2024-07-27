<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_ticket',
        'title_ticket',
        'mulai_kerja',
        'akhir_kerja',
        'description',
        'extra_desc',
    ];

    public function save(array $options = [])
    {
        $this->description = "[{$this->code_ticket}] {$this->title_ticket}";
        parent::save($options);
    }

    public static function rules()
    {
        return [
            'mulai_kerja' => 'required|date_format:Y-m-d H:i:s',
            'akhir_kerja' => 'required|date_format:Y-m-d H:i:s|after:mulai_kerja',
        ];
    }
    

public function getTotalHoursAttribute()
{
    if ($this->mulai_kerja && $this->akhir_kerja) {
        $start = Carbon::parse($this->mulai_kerja);
        $end = Carbon::parse($this->akhir_kerja);
        $diffInHours = $end->diffInHours($start);
        $diffInMinutes = $end->diffInMinutes($start) % 60;
        return sprintf("%d jam %d menit", $diffInHours, $diffInMinutes);
    }
    return "0 jam 0 menit";
}

}
