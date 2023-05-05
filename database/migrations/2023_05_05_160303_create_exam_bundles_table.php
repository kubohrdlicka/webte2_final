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
        Schema::create('exam_bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignId("assignment_id")->references('id')->on('assignments');
            $table->foreignId("task_bundle_id")->references('id')->on('task_bundles');
            $table->integer("points");
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
        Schema::dropIfExists('exam_bundles');
    }
};
