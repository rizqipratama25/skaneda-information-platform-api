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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('dateTime');
            $table->unsignedBigInteger('made_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('made_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::table('agendas', function (Blueprint $table) {
            $table->foreignId('created_by')->after('dateTime')->constrained('users')->restrictOnDelete();
            $table->foreignId('updated_by')->after('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('deleted_by')->nullable()->after('updated_by')->constrained('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
