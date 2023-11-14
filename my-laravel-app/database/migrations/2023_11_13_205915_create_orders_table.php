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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialization_id');
            $table->unsignedBigInteger('client_id');
            $table->integer('hours'); //??? а как потом в часах считать?
            $table->integer('minutes');
            $table->decimal('total_amount', 10, 2); // без запятой
            $table->text('description')->nullable();
            $table->text('comments')->nullable();
            $table->text('materials')->nullable();
            $table->timestamps();

            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
