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
        Schema::create('srd', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_name');
            $table->string('source');
            $table->string('sub_source');
            $table->string('project_name');
            $table->string('medium_name');
            $table->string('medium_value');
            $table->string('srd');
            $table->string('sell_do_project_id');
            $table->string('project_id');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srd');
    }
};
