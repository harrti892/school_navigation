<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->string('node_id')->unique(); // 節點 ID，例如 A、B、C
            $table->decimal('svg_x', 8, 2); // SVG 座標 X
            $table->decimal('svg_y', 8, 2); // SVG 座標 Y
            $table->string('floor');        // 所在樓層
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
        Schema::dropIfExists('nodes');
    }
}
