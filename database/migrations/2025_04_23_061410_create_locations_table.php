<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 地點名稱，如：T0301
            $table->enum('type', ['indoor', 'outdoor']); // 室內或室外
            $table->decimal('lat', 10, 6)->nullable();   // GPS 緯度（室外）
            $table->decimal('lng', 10, 6)->nullable();   // GPS 經度（室外）
            $table->string('floor')->nullable();         // 所在樓層（室內用）
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
        Schema::dropIfExists('locations');
    }
}
