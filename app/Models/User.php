<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLES = [
        'root' => 1,
        'member' => 2,
    ];

    const ROLETASKS = [
        "Admin" => 1,
        "Giám sát department" => 2,
        "Giám sát activity" => 3,
        "Người phối hợp" => 4,
        "Người theo dõi" => 5,
        "Chủ task" => 6,
        "Người thực hiện" => 7, 
   ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    protected $appends = ['avatar', 'role_follower', 'role_performer'];
    
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    public function isRoot()
    {
        return $this->role === static::ROLES['root'];
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function getAvatarAttribute()
    {
       return $this->attachment ? "/storage/attachments/".$this->attachment->file_name  : "/assets/img/images.png";
    }

   public function getRoleFollowerAttribute()
   {
       return $this->role_task === static::ROLETASKS['Người theo dõi'];
   }

   public function getRolePerformerAttribute()
   {
       return $this->role_task === static::ROLETASKS['Người thực hiện'];
   }
}
