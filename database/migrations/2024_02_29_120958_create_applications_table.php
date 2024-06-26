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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no');
            $table->date('application_date');
            $table->time('application_time');
            $table->string('notes');
            $table->bigInteger('stage_id');
            $table->bigInteger('who_assigned');
            $table->bigInteger('for_whom');
            $table->bigInteger('lead_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
