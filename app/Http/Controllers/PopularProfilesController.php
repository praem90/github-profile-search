<?php

namespace App\Http\Controllers;

use App\Repositories\ProfileRepository;

class PopularProfilesController extends Controller
{
	public function __invoke(ProfileRepository $profileRepository)
	{
		$filters = [];

		$filters['limit'] = request('limit', 3);
		$filters['orders'] = [
			'view_count' => 'desc',
		];

		$profiles = $profileRepository->get($filters, ['login', 'avatar_url', 'public_repos']);

		return response()->json($profiles);
	}
}
