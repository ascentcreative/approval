<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


use AscentCreative\Approval\Models\ApprovalItem;

class AddActionLabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approval_queue', function (Blueprint $table) {
            $table->string('action_label')->nullable()->after('action');
        });

        DB::update(

            DB::Raw("update approval_queue set action_label = 

            CONCAT(UCASE(LEFT(action, 1)), 
                             SUBSTRING(action, 2))")

        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approval_queue', function (Blueprint $table) {
            $table->dropColumn('action_label');
        });
    }
}
