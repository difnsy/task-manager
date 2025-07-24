<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

// app/Models/Task.php
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

// database/migrations/create_tasks_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->datetime('deadline')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};