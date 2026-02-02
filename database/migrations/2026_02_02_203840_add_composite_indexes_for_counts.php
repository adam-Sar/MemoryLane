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
        Schema::table('post_likes', function (Blueprint $table) {
            // Composite index for counting likes per post
            $table->index(['post_id', 'user_id'], 'post_likes_post_user_idx');
        });

        Schema::table('comment_likes', function (Blueprint $table) {
            // Composite index for counting likes per comment
            $table->index(['comment_id', 'user_id'], 'comment_likes_comment_user_idx');
        });

        Schema::table('comments', function (Blueprint $table) {
            // Composite index for counting comments per post
            $table->index(['post_id', 'id'], 'comments_post_id_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_likes', function (Blueprint $table) {
            $table->dropIndex('post_likes_post_user_idx');
        });

        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropIndex('comment_likes_comment_user_idx');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('comments_post_id_idx');
        });
    }
};
