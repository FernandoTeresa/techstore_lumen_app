<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()

    {Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('username',50);
        $table->string('password');
        $table->string('first_name',50);
        $table->string('last_name',50);
        $table->string('email',80);
        $table->boolean('admin')->default(false);
        $table->timestamp('updated_at')->nullable()->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'));
        $table->timestamp('created_at')->useCurrent();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
