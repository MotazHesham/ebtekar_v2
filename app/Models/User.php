<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'address','device_token',
        'photo', 'user_type', 'phone_number', 'store_name',
        'wasla_token','wasla_company_id','provider_id'
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

    public function canAccessFilament(): bool
    {
        return $this->user_type == 'staff';
    }

    public function is_admin(){
        return $this->roles()->where('id', 1)->exists();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'model_has_roles','model_id','role_id')->withPivot('model_type');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function conversations(){
        return $this->hasMany(Conversation::class,'sender_id');
    }
    public function conversations_2(){
        return $this->hasMany(Conversation::class,'receiver_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function social_orders()
    {
        return $this->hasMany(Order::class,'social_user_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function seller(){
        return $this->hasOne(Seller::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function calenders()
    {
        return $this->hasMany(Calender::class);
    }
}
