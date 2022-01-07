<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktakelahiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktakelahirans', function (Blueprint $table) {
            $table->id();
            $table->string('ktp_ayah');
            $table->string('ktp_ibu');
            $table->string('ktp_saksi1');
            $table->string('ktp_saksi2');
            $table->string('nama_anak');
            $table->integer('anak_ke');
            $table->string('tempatlahir');
            $table->date('tanggallahir')->default(now());
            $table->string('hari');
            $table->time('jam')->default(now());
            $table->string('agama');
            $table->string('alamat');
            $table->string('ttdsaksi1');
            $table->string('ttdsaksi2');
            $table->string('uid_user');
            $table->timestamps();
            $table->enum('status_verifikasi', ['belumdiverifikasi', 'sedangproses','selesai']);   
            $table->foreign('uid_user')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');

        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktakelahirans');
    }
}
