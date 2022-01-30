<?php

namespace App\Repositories;

use App\Models\Profile;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Support\Collection;

class GithubRepository
{
	/**
 	 * No of days to cache user details
 	 *
 	 * @var int
 	 */
	const USER_DETAILS_CACHE_DURATION = 10;

    /**
     * @var ProfileRepository
     */
    private $profileRepository;

	public function __construct(ProfileRepository $profileRepository){
		$this->profileRepository = $profileRepository;
	}

	public function search($query) {
		$response = GitHub::api('search')->users($query, 'followers', 'desc');

		if ($response['total_count'] === 0) {
			return [];
		}

		// TODO: Optimize. Gateway timeout exception because of making 30 more requsts
		// to get profile detail
		$users = collect($response['items'])->map(function ($user) {
			$user = GitHub::api('user')->show($user['login']);
			$user['repos'] = collect(Github::api('user')->repositories($user['login']))->map(function ($repo) {
				return [
					'id' => $repo['id'],
					'profile_id' => $repo['owner']['id'],
					'name' => $repo['name'],
					'full_name' => $repo['full_name'],
					'stargazers_count' => $repo['stargazers_count'],
					'forks_count' => $repo['forks_count'],
				];
			});

			return $user;
		})->keyBy('login');

		$this->updateUsersIfExists($users);
		$this->createUsersIfNotExists($users);

		return $users;
	}

	public function getExistingUsers($users, $cache_expired = false)
	{
		$filters['login'] = $users->pluck('login')->all();
		$filters['limit'] = 100;

		if ($cache_expired) {
			$filters['last_fetched_at'] = [
				'max' => now()->subDays(self::USER_DETAILS_CACHE_DURATION)
			];
		}

		return $this->profileRepository->get($filters, ['login'])->pluck('login')->all();
	}

	public function updateUsersIfExists(Collection $users)
	{
		$existingUsers = $this->getExistingUsers($users, true);

		$users = $users->only($existingUsers)->each(function ($user) {
			$profile = Profile::with('detail')->find($user['id']);

			$this->profileRepository->save($profile, $user);
		});
	}

	public function createUsersIfNotExists(Collection $users)
	{
		$existingUsers = $this->getExistingUsers($users);

		$this->profileRepository->bulkInsert($users->except($existingUsers));
	}
}
