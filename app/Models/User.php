<?php

namespace App\Models;

use App\Follower;
use Illuminate\Support\Str;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
	use Notifiable, HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'code', 'name', 'last_name', 'email', 'phone_number', 'verified', 'password', 'permission', 'type'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];



	/**
	 * Brings out the info from the Address table that belongs to the customers
	 *
	 * @var array
	 */
	public function addresses()
	{
		return $this->hasMany(Address::class);
	}

	public function user_apartments()
	{
		return $this->belongsToMany(Apartment::class, 'apartment_user');
	}




	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function active_address()
	{
		return $this->hasOne(Address::class)->where('is_active', 1);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function carts()
	{
		return $this->hasMany(Cart::class);
	}

	public function favorites()
	{
		return $this->hasMany(Favorite::class);
	}


	public function user_reservations()
	{
		return $this->hasMany(UserReservation::class);
	}


	public function social()
	{
		return $this->hasMany(UserSocial::class);
	}


	public function activities()
	{
		return $this->hasMany(Activity::class);
	}

	public function hasSocialLinked($service)
	{
		return (bool) $this->social->where('service', $service)->count();
	}


	public function fullname()
	{
		return ucfirst($this->name) . ' ' . ucfirst($this->last_name);
	}


	public function users_permission()
	{
		return $this->hasOne(UserPermission::class);
	}


	public function properties()
	{
		return $this->belongsToMany(Property::class);
	}


	public function apartments()
	{
		return $this->belongsToMany(Apartment::class);
	}

	public function scopeCustomers(Builder $builder)
	{
		return $builder->where('type', 'subscriber');
	}

	public function scopeAgents(Builder $builder)
	{
		return $builder->where('type', 'agent');
	}

	public function scopeAdmin(Builder $builder)
	{
		return $builder->whereNull('type');
	}


	public function ActiveAddress()
	{
		return optional($this->addresses)->where('is_active', true)->first();
	}


	public static function userHasPermission($num)
	{
		$model = \Auth::user();
		return Str::contains($model->users_permission->permission->code, $num) ? true : false;
	}


	public static function canTakeAction($num)
	{
		if (!User::userHasPermission($num)) {
			dd('You dont have access,Permission Denied.');
		}
	}


	public function isAgent()
	{
		return $this->type  == 'agent' ? true : false;
	}


	public function isAdmin()
	{
		return $this->users_permission  !== null ? true : false;
	}

	public static function IsSuperUser()
	{
		$model = \Auth::user();
		return $model->users_permission->permission->name == 'Super User' ? true : false;
	}

	public function activity()
	{
		return $this->hasMany(Activity::class);
	}

	public function hasVerified()
	{
		$this->verified = true;
		$this->token = null;
		$this->save();
	}
}
