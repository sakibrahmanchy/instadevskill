<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactables', function (Blueprint $table) {
            $table->foreignId('reaction_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->morphs('reactable');
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
        Schema::table('reactables', function (Blueprint $table) {
            $table->dropForeign(['reaction_id']);
        });
        Schema::dropIfExists('reactables');
    }
}
