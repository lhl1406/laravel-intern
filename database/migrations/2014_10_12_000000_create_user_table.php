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
        Schema::create('user', function (Blueprint $table) {
            $table->bigInteger('id', true)->nullable(false)->unique();
            $table->string('email', 255)->nullable(false);
            $table->string('password', 255)->nullable(false);
            $table->string('name', 100)->nullable(false);
            $table->bigInteger('group_id')->nullable(false);
            $table->date('started_date')->nullable(false);
            $table->tinyInteger('position_id')->nullable(false);
            $table->date('created_date')->nullable(false);
            $table->date('updated_date')->nullable(false);
            $table->date('deleted_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
