<?php

namespace App\Jobs;

use App\Repositories\GithubRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class ImportProfilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public string $query;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $query)
    {
		$this->query = $query;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GithubRepository $githubRepository)
    {
		// We never import all the github profiles. Instead insert
		// profiles only when search query is available
		// Remember users list per query string for 24hrs
		// Insert into the database if cache key is invalid
		Cache::remember('profiles_search_' . $this->query, 60*60*24, function () use ($githubRepository) {
			return $githubRepository->search($this->query);
		});
    }
}
