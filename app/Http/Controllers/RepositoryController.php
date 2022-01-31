<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
	public function __invoke($profile_id)
	{
		$repos = Repository::where('profile_id', $profile_id);

		return $repos->paginate(request('limit', 30));
	}
}
