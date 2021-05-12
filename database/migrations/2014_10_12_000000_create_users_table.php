<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        DB::table('groups')->insert(
            array(
                'name' => 'English',
            )
        );
        DB::table('groups')->insert(
            array(
                'name' => 'Meth',
            )
        );

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->foreignId('group_id')->nullable()->constrained('groups');
        });

        DB::table('users')->insert(
            array(
                'login' => 'ad',
                'password' => 'ad',
                'admin' => true,
            )
        );

        DB::table('users')->insert(
            array(
                'login' => 'Andrzej',
                'password' => 'qq',
                'group_id' => 1
            )
        );

//        foreach (array('Adam', 'Maria', "Damian", "Pawel", "Wojtek", "Agata", 'Magda', 'Wera') as $x) {
        foreach (array('Adam', 'Maria', "Damian") as $x) {
            DB::table('users')->insert(
                array(
                    'login' => $x,
                    'password' => 'qq',
                )
            );
        }
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
