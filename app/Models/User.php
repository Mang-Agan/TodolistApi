<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Todolist;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAllTodolist()
    {
        $todolists = $this->hasMany(Todolist::class, 'user_id', 'id')->get();
        $response = collect([]);
        foreach ($todolists as $todo) {
            $response->push([
                'id' => $todo->id,
                'todo' => $todo->todo,
                'is_chacked' => $todo->is_check,
                'created_at' => Carbon::parse($todo->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($todo->updated_at)->format('Y-m-d H:i:s')
            ]);
        }
        return $response;
    }
}
