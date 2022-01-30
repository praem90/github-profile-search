<?php

namespace App\Http\Controllers;

use App\Repositories\GithubRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
	public function __invoke(GithubRepository $githubRepository, ProfileRepository $profileRepository)
	{
		if (request()->has('query') && request('force')) {
			// We never import all the github profiles. Instead insert
			// profiles only when search query is available
			// Remember users list per query string for 24hrs
			// Insert into the database if cache key is invalid
			Cache::remember('profiles_search_' . request('query'), 60*60*24, function () use ($githubRepository) {
				return $githubRepository->search(request('query'));
			});
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
