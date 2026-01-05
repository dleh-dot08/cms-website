<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;

class NewsController extends BasePostController
{
    protected string $jenis = Post::JENIS_NEWS;
    protected string $label = 'News';
    protected string $routeBase = 'admin.news';
}
