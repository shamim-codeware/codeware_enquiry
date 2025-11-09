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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->timestamp('next_follow_up_date')->nullable();
            $table->unsignedBigInteger('followup_id')->nullable();
            $table->unsignedBigInteger('enquiry_id')->nullable();
            $table->unsignedBigInteger('showroom_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('assign')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('ex_seen')->default(0);
            $table->boolean('man_seen')->default(0);
            $table->boolean('admin_seen')->default(0);

            $table->string('notifications_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
