<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktaKelahiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akta_kelahirans', function (Blueprint $table) {
            $table->id();
            $table->string('uid_ayah');
            $table->string('uid_ibu');
            $table->string('uid_saksi1');
            $table->string('uid_saksi2');
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
            $table->timestamps();
            $table->enum('status_verifikasi', ['belumdiverifikasi', 'sedangproses','selesai']);   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akta_kelahirans');
    }
}
