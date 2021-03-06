<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('uid',32)->primary();
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('nik');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('alamat_lengkap');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });


        Schema::create('update_auths', function (Blueprint $table) {
            $table->id();
            $table->string('uid_user',32)->nullable();
            $table->string('keterangan');
            $table->string('fotoktp');
            $table->enum('status',['belum_dikonfirmasi','sudah_dikonfirmasi','ditolak']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        
        Schema::table('update_auths', function (Blueprint $table) {
            $table->foreign('uid_user')->references('uid')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
        
       

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
