<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddColumnsInAnnouncementsTable
 */
class AddColumnsInAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->foreignId('announcement_type_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('payment_method_id')->constrained();
            $table->foreignId('profile_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('profile_id');
            $table->dropColumn('payment_method_id');
            $table->dropColumn('condition_id');
            $table->dropColumn('category_id');
            $table->dropColumn('type_announcement_id');
        });
    }
}
