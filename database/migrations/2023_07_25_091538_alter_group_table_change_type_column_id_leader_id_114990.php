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
        Schema::table('group', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->dropColumn('id');
            $table->unsignedBigInteger('group_leader_id')->change();
        });

        Schema::table('group', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->nullable(false)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
