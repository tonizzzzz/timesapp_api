<?php

// app/Models/TimeEntry.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeEntry extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'clock_in', 'clock_out'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    public function workedTimeInSeconds()
    {
        if ($this->clock_out) {
            return Carbon::parse($this->clock_in)->diffInSeconds($this->clock_out);
        } else {
            return Carbon::parse($this->clock_in)->diffInSeconds(now());
        }
    }
}
