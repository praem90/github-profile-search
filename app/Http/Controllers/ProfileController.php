<?php

namespace App\Http\Controllers;

use App\Models\Profile;

class ProfileController extends Controller
{
	public function __invoke($login)
	{
		$profile = Profile::with(['detail'])->whereLogin($login)->firstOrFail();

		$profile->increment('view_count');

		return response()->json($profile);
	}
}
