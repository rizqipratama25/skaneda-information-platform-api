
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
        Schema::create('job_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('open_positions');
            $table->string('position');
            $table->foreignId('type_id')->nullable()->constrained('job_types')->restrictOnDelete();
            $table->string('location');
            $table->text('description');
            $table->string('registration_link');
            $table->foreignId('status_id')->nullable()->constrained('statuses')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
