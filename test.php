<?php
use App\Models\Post;

$posts = Post::latest()->take(3)->get();
foreach($posts as $post) {
    echo $post->title . "\n";
    echo $post->screenshot_path . "\n";
}
