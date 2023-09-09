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
        Schema::create('website_metadata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("request_id");
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('screenshot_filename')->nullable();
            $table->string('body_filename')->nullable();
            $table->timestamp('publish_date')->nullable();
            // created_at and updated_at of the record, not website
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign("request_id")->references("id")->on("url_requests")->onDelete("cascade");
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
