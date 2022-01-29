<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileDetail extends Model
{
    use HasFactory;

	protected $dates = [
		'last_fetched_at'
	];

	protected $casts = [
		'followers' => 'int',
		'public_repos' => 'int',
		'view_count' => 'int',
	];

	public function profile() {
		return $this->belongsTo(Profile::class);
	}
}
