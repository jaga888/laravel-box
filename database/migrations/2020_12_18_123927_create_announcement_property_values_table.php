<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateAnnouncementPropertyValuesTable
 */
class CreateAnnouncementPropertyValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_property_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')
                ->constrained();
            $table->foreignId('property_value_id')
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcement_property_values');
    }
}
