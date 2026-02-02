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
        Schema::table('optimize_performance', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('post_id');
            $table->index('comment_id');
            $table->index('tag');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('optimize_performance', function (Blueprint $table) {
            //
        });
    }
};
