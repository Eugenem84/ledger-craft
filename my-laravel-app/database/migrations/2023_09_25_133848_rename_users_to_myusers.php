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
        Schema::rename('users','myusers' );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('myusers', function (Blueprint $table) {
            //
        });
    }
};
