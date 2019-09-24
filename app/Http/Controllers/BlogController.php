<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Resources\BlogDetailResource;
use App\Http\Resources\BlogResource;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class BlogController extends Controller
{
    public function get() {
        return BlogResource::collection(Blog::all());
    }

    public function getById(int $id) {
        return new BlogDetailResource(Blog::find($id));
    }
}
