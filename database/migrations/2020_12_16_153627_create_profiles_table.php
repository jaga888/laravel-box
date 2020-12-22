<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateProfilesTable
 */
class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_profile_id')
                ->comment('Тип профиля: физическое или юридическое лицо');
            $table->foreignId('user_id')->constrained();
            $table->string('fio')
                ->comment('ФИО');
            $table->string('slug')
                ->comment('Алияс для урла');
            $table->string('unp')
                ->nullable()
                ->comment('УНП');
            $table->string('registration_photo')
                ->nullable()
                ->comment('Фото копии свидетельства о регистрации');
            $table->string('site')
                ->nullable()
                ->comment('Адрес сайта');
            $table->longText('description')
                ->nullable()
                ->comment('Описание профиля');
            $table->string('email')
                ->nullable()
                ->comment('email');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
