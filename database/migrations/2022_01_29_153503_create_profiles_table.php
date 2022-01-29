<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->string('login', 60)->unique();
            $table->string('avatar_url');
            $table->string('html_url');

            $table->unsignedInteger('followers')->index();
            $table->unsignedSmallInteger('public_repos')->index();
            $table->unsignedSmallInteger('view_count')->index();

            $table->timestamp('last_fetched_at');
            $table->timestamps();
		});

        Schema::create('profile_details', function (Blueprint $table) {
            $table->foreignId('profile_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('node_id', 60);
            $table->string('gravatar_id');
            $table->string('url');
            $table->string('followers_url');
            $table->string('following_url');
            $table->string('gists_url');
            $table->string('starred_url');
            $table->string('subscriptions_url');
            $table->string('organizations_url');
            $table->string('repos_url');
            $table->string('events_url');
            $table->string('received_events_url');
            $table->boolean('site_admin');

            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('blog')->nullable();
            $table->string('location')->nullable();
            $table->string('email', 60)->nullable();
            $table->boolean('hirable')->nullable();
            $table->text('bio')->nullable();
            $table->string('twitter_username', 60)->nullable();
            $table->unsignedSmallInteger('public_gists')->nullable();
            $table->unsignedInteger('following')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('profile_details');
    }
}
