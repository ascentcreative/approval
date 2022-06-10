<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_queue', function (Blueprint $table) {
            $table->id();
            $table->string('action')->index();
            $table->string('approvable_type')->index();
            $table->integer('approvable_id')->index()->nullable();
            $table->integer('author_id');
            $table->text('payload');
            $table->integer('is_approved')->index();
            $table->timestamp('approved_at')->index()->nullable();
            $table->integer('approved_by')->index()->nullable();
            $table->integer('is_rejected')->index();
            $table->timestamp('rejected_at')->index()->nullable();
            $table->integer('rejected_by')->index()->nullable();
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
        Schema::dropIfExists('approval_queue');
    }
}
