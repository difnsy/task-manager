<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'deadline', 'is_completed', 'user_id'];
    protected $casts = ['deadline' => 'datetime', 'is_completed' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsOverdueAttribute()
    {
        return $this->deadline && Carbon::now()->gt($this->deadline) && !$this->is_completed;
    }

    public function getDaysUntilDeadlineAttribute()
    {
        if (!$this->deadline) return null;
        return Carbon::now()->diffInDays($this->deadline, false);
    }
}