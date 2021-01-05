<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->id();
            $table->string('title')
                ->nullable()
                ->comment('Meta: title.');
            $table->string('description')
                ->nullable()
                ->comment('Meta: description.');
            $table->string('keywords')
                ->nullable()
                ->comment('Meta: keywords.');
            $table->string('url')
                ->nullable()
                ->comment('Meta: canonical url.');
            $table->string('robots')
                ->comment('Meta: robots.');
            $table->boolean('no_archive')
                ->default(false)
                ->comment('Meta: NOARCHIVE');
            $table->boolean('no_odr')
                ->default(false)
                ->comment('Meta: NOODP');
            $table->boolean('no_snippet')
                ->default(false)
                ->comment('Meta: NOSNIPPET');
            $table->boolean('no_ydir')
                ->default(false)
                ->comment('Meta: NOYDIR');
            $table->integer('xml_status')
                ->comment('Meta: xmlsitemap status');
            $table->string('xml_options')
                ->comment('Meta: xmlsitemap options');
            $table->unsignedInteger('entity_id')
                ->comment('ID сущности к которой прикреплены данные.');
            $table->index('entity_id');
            $table->string('entity_type')
                ->comment('Название сущности.');
            $table->index('entity_type');
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
        Schema::dropIfExists('seo');
    }
}
