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
        return BlogResource::collection(Blog::orderBy('id', 'DESC')->paginate(6));
    }

    public function getLatest(int $skipId) {
        return BlogResource::collection(Blog::where('id', '!=', $skipId)->orderBy('id', 'DESC')->paginate(6));
    }

    public function getById(int $id) {
        $prevId = Blog::where('id', '>', $id)->orderBy('id', 'ASC')->first();
        $nextId = Blog::where('id', '<', $id)->orderBy('id', 'DESC')->first();

        return ['previous' => $prevId, 'next' => $nextId, 'current' => new BlogDetailResource(Blog::find($id))];
    }
}
