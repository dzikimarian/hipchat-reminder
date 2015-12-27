<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelateNotificationsWithReceivers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
			$table->integer('receiver_id')->unsigned()->default(1);
			$table->foreign('receiver_id')->references('id')->on('receivers');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign('notifications_receiver_id_foreign');
		$table->dropColumn('receiver_id');
    }
}
