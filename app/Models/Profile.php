<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

	protected $fillable = [
		'id',
		'login',
		'avatar_url',
		'html_url',
		'followers',
		'public_repos',
		'view_count',
		'last_fetched_at',
	];

	protected $dates = [
		'last_fetched_at'
	];

	protected $casts = [
		'followers' => 'int',
		'public_repos' => 'int',
		'view_count' => 'int',
	];

	public function detail() {
		return $this->hasOne(ProfileDetail::class);
	}
}
