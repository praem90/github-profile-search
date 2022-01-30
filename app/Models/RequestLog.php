<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLog extends Model
{
    use HasFactory;

	public $casts = [
		'request_body' => 'json',
		'response_body' => 'json',
	];
}
