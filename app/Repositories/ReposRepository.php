<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\ProfileDetail;
use App\Models\Repository;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ReposRepository
{
	public function getModel() {
		return Repository::query();
	}

	public function get(array $filters, array $columns = ['*']) {
		return $this->applyFilters($filters)
			  ->select($columns)
			  ->paginate(
				  Arr::get($filters, 'limit', 3)
			  );
	}

	public function applyFilters($filters, $query = null) {
		$query = $query ?: $this->getModel();

		$query->when(Arr::get($filters, 'login'), function ($query, $logins) {
			$logins = is_array($logins) ? $logins : [$logins];
			$query->whereIn('login', $logins);
		});

		$query->when(Arr::get($filters, 'last_fetched_at.max'), function ($query, $last_fetched_at) {
			$query->where('last_fetched_at', '<', $last_fetched_at);
		});

		$query->when(Arr::get($filters, 'last_fetched_at.min'), function ($query, $last_fetched_at) {
			$query->where('last_fetched_at', '>', $last_fetched_at);
		});

		$query->when(Arr::get($filters, 'query'), function ($query, $search) {
			$query->where('login', 'like', '%' . $search . '%');
		});

		$query->when(Arr::get($filters, 'orders'), function ($query, $orders) {
			foreach ($orders as $sort => $order) {
				$query->orderBy($sort, $order);
			}
		});

		return $query;
	}

	public function save(Profile $profile, array $user)
	{
		list($profile, $detail) =  $this->mapGithubUserData($profile, $user);

		$profile->save();
		$profile->detail->save($detail);

		Repository::where('profile_id', $user['profile']->id)
			->whereIn('id', $user['repos']->pluck('id')->all()->toArray())
			->delete();

		Repository::insert($user['repos']->toArray());

		return $profile;
	}

	public function mapGithubUserData(Profile $profile, array $user)
	{
		$profile->id = $user['id'];
		$profile->login = $user['login'];
		$profile->avatar_url = $user['avatar_url'];
		$profile->html_url = $user['html_url'];
		$profile->followers = $user['followers'];
		$profile->public_repos = $user['public_repos'];
		$profile->view_count = Arr::get($user, 'view_count', 0);

		$details = $profile->relationLoaded('detail') ? $profile->detail : new ProfileDetail;
		$details->profile_id = $profile->id;
		$details->node_id = $user['node_id'];
		$details->gravatar_id = $user['gravatar_id'];
		$details->url = $user['url'];
		$details->followers_url = $user['followers_url'];
		$details->following_url = $user['following_url'];
		$details->gists_url = $user['gists_url'];
		$details->starred_url = $user['starred_url'];
		$details->subscriptions_url = $user['subscriptions_url'];
		$details->organizations_url = $user['organizations_url'];
		$details->repos_url = $user['repos_url'];
		$details->events_url = $user['events_url'];
		$details->received_events_url = $user['received_events_url'];
		$details->site_admin = $user['site_admin'];

		$details->name = Arr::get($user, 'name');
		$details->company = Arr::get($user, 'company');
		$details->location = Arr::get($user, 'location');
		$details->email = Arr::get($user, 'email');
		$details->blog = Arr::get($user, 'blog');
		$details->hirable = Arr::get($user, 'hirable');
		$details->bio = Arr::get($user, 'bio');
		$details->twitter_username = Arr::get($user, 'twitter_username');
		$details->public_gists = Arr::get($user, 'public_gists');
		$details->following = Arr::get($user, 'following');
		$details->created_at = Carbon::parse(Arr::get($user, 'created_at'))->toDateTimeString();
		$details->updated_at = Carbon::parse(Arr::get($user, 'updated_at'))->toDateTimeString();

		$repos = $user['repos'];

		return ['profile' => $profile, 'detail' => $details, 'repos' => $repos];
	}

	public function bulkInsert(Collection $users)
	{
		$users = $users->map(function ($user) {
			return $this->mapGithubUserData(new Profile, $user);
		});

		$profiles = $users->pluck('profile');
		$details = $users->pluck('detail');

		Profile::insert($profiles->toArray());
		ProfileDetail::insert($details->toArray());

		$users->each(function ($user) {
			Repository::insert($user['repos']->toArray());
		});
	}
}
