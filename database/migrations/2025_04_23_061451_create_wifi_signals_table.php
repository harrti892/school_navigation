<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWifiSignalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wifi_signals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id'); // 對應到地點
            $table->string('ssid');    // Wi-Fi 名稱
            $table->string('bssid');   // MAC 位址
            $table->integer('rssi');   // 訊號強度
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wifi_signals');
    }
}
