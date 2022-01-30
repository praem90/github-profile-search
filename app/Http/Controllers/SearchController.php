<?php

namespace App\Http\Controllers;

use App\Jobs\ImportProfilesJob;
use App\Repositories\ProfileRepository;

class SearchController extends Controller
{
	public function __invoke(ProfileRepository $profileRepository)
	{
		if (request()->has('query') && request('force')) {
			ImportProfilesJob::dispatch(request('query'));
		}

		$filters = [];

		$filters['query'] = request('query');
		$filters['limit'] = request('limit', 3);
		$filters['orders'] = [
			'followers' => 'desc',
			'public_repos' => 'desc',
			'view_count' => 'desc',
		];

		$profiles = $profileRepository->get($filters, ['login', 'avatar_url', 'public_repos']);

		return response()->json($profiles);
	}
}
