<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username',50);
            $table->string('password');
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('email',80);
            $table->string('address_1',80);
            $table->string('address_2',100);
            $table->string('city',30);
            $table->integer('postal_code');
            $table->string('country',30);
            $table->integer('mobile');
            $table->integer('telephone');
            $table->boolean('high_permission', false);
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
};
