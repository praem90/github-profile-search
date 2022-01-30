<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();
            $table->foreignId('profile_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name', 60);
            $table->string('full_name', 60);
            $table->unsignedInteger('stargazers_count');
            $table->unsignedInteger('forks_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repositories');
    }
}
