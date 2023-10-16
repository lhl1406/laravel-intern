<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('group', function (Blueprint $table) {
            $table->bigInteger('id', true)->unique()->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->text('note')->nullable();
            $table->bigInteger('group_leader_id')->nullable(false);
            $table->integer('group_floor_number')->nullable(false);
            $table->date('created_date')->nullable(false);
            $table->date('updated_date')->nullable(false);
            $table->date('deleted_date')->nullable();
            $table->foreign('group_leader_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group');
    }
};
