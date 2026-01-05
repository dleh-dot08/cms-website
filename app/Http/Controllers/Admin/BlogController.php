<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;

class BlogController extends BasePostController
{
    protected string $jenis = Post::JENIS_BLOG;
    protected string $label = 'Blog';
    protected string $routeBase = 'admin.blogs';
}
