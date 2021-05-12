<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Questions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('body');
        });
        DB::table('questions')->insert(
            array(
                'body' => 'What do they speak in england?',
            )
        );
        DB::table('questions')->insert(
            array(
                'body' => 'What are kangaroos?',
            )
        );
        DB::table('questions')->insert(
            array(
                'body' => 'What day is today?',
            )
        );

        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->string('body');
            $table->foreignId('question_id')->constrained('questions');
            $table->boolean('correct')->default(false);
        });
        DB::table('answers')->insert(
            array(
                'body' => 'English',
                'question_id' => 1,
                'correct' => true,
            )
        );
        DB::table('answers')->insert(
            array(
                'body' => 'Estonian',
                'question_id' => 1,
            )
        );
        DB::table('answers')->insert(
            array(
                'body' => 'Plants',
                'question_id' => 2,
            )
        );
        DB::table('answers')->insert(
            array(
                'body' => 'Animals',
                'question_id' => 2,
                'correct' => true,
            )
        );
        DB::table('answers')->insert(
            array(
                'body' => 'Monday',
                'question_id' => 3,
            )
        );
        DB::table('answers')->insert(
            array(
                'body' => 'Sunday',
                'question_id' => 3,
                'correct' => true,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
