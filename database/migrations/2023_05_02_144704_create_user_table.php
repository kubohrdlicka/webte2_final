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
            $table->string("name");
            $table->string("surname");
            $table->string("email", 100)->unique();
            $table->string("password");
            $table->string("role")->default("student");
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'name' => 'admin01',
                'surname' => 'admin01',
                'email' => 'admin@admin.admin',
                'password' => bcrypt('Admin01'),
                'role' => 'admin')
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
