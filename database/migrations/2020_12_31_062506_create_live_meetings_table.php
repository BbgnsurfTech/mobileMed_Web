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
        Schema::create('live_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('consultation_title');
            $table->dateTime('consultation_date');
            $table->string('consultation_duration_minutes');
            $table->boolean('host_video');
            $table->boolean('participant_video');
            $table->text('description')->nullable();
            $table->string('created_by');
            $table->text('meta')->nullable();
            $table->string('time_zone')->default(null);
            $table->string('password');
            $table->integer('status');
            $table->string('tenant_id')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_meetings');
    }
};
