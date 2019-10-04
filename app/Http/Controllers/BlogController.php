<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Http\Requests\BlogCreateRequest;
use App\Http\Resources\BlogDetailResource;
use App\Http\Resources\BlogResource;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function get() {
        return BlogResource::collection(Blog::orderBy('id', 'DESC')->paginate(6));
    }

    public function getLatest(int $skipId) {
        return BlogResource::collection(Blog::where('id', '!=', $skipId)->orderBy('id', 'DESC')->paginate(6));
    }

    public function getById(int $id) {
        $prev = Blog::where('id', '>', $id)->orderBy('id', 'ASC')->first();
        $next = Blog::where('id', '<', $id)->orderBy('id', 'DESC')->first();

        return [
            'previous' => is_null($prev) ? null : new BlogResource($prev),
            'next' => is_null($next) ? null : new BlogResource($next),
            'current' => new BlogDetailResource(Blog::find($id))
        ];
    }

    public function getBlogImage($blogId) {
        $buf = Blog::find($blogId, 'wallpaper');

        $filename = is_null($buf) ? null : $buf['wallpaper'];

        //$path = storage_path('app/images/blogs/' . $filename);
        $file = Storage::get($filename);

//        if (!File::exists($path)) {
//            abort(404);
//        }

        //$file = File::get($path);
        $type = Storage::mimeType($filename);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;

    }

    public function newBlog(BlogCreateRequest $request) {
        $date = $request->input('date');
        $location = $request->input('location');
        $duration = $request->input('duration');
        $title = $request->input('title');
        $body = $request->input('body');
        $goalAudience = $request->input('goal_audience');
        $image = $request->file('image');

        $imageName = md5(time().uniqid()) . '.' . $image->getClientOriginalExtension();
        //$image->move(storage_path('app/images/blogs/'), $imageName);
        $imageName = $image->store('images/blogs');

        $blog = new Blog();

        $blog->date = $date;
        $blog->location = $location;
        $blog->duration = $duration;
        $blog->title = $title;
        $blog->body = $body;
        $blog->goal_audience = $goalAudience;
        $blog->wallpaper = $imageName;
        $blog->user_id = auth()->id();

        try {
            $blog->save();
        } catch (QueryException $exception) {
            Storage::delete($imageName);
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 406);
        }

        return response()->json(['message' => 'new blog added', 'id' => $blog->id]);
    }
}
