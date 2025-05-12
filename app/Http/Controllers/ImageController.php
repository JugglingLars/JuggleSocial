<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessImage;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Vips\Driver as VipsDriver;

class ImageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $images = Image::with(['comments', 'tags'])->get();

        $image_ids = $images->pluck('id')->filter()->values()->toArray();

        // bulk query to prevent a lot of small queries from eager loading
        $likesCount = Like::where('likeable_type', 'App\Models\Image')
            ->whereIn('likeable_id', Arr::flatten($image_ids))
            ->groupBy('likeable_id')
            ->selectRaw('likeable_id, COUNT(*) as likes_count')
            ->get()
            ->pluck('likes_count', 'likeable_id');

        $isLikedByUser = Like::where('likeable_type', 'App\Models\Image')
            ->whereIn('likeable_id', Arr::flatten($image_ids))
            ->where('user_id', $user->id)
            ->get()
            ->pluck('id','likeable_id')
            ->toArray();

        foreach ($images as $image) {
            $image->likes_count = $likesCount[$image->id]??0;
            $image->user_like_id = $isLikedByUser[$image->id]??0;
        }

        return view('images.index',[
            'images'=>$images
        ]);
    }
    
    public function create()
    {
        $tags = Tag::all();
        return view('images.create',[
            'tags' => $tags
        ]);
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255',
            'file' => 'image|mimes:png',
            'tags' => 'array', 
            'tags.*' => 'integer|exists:tags,id' // Ensure each tag is an integer and exists in the tags table
        ]);
        
        $image = $request->file('file');
        $imagePath = $image->store('temp', 'public');

        $dbImage = Image::create([
            'description' => $data['description'],
            'user_id' => Auth::id(),
            'image_full_name' => basename($imagePath)
        ]);
    
        if (isset($data['tags'])) {
            $dbImage->tags()->attach($data['tags']);
        }

        ProcessImage::dispatch($dbImage->id);

        return redirect()->route('images.show', $dbImage);
    }

    public function show(Image $image)
    {
        $user = Auth::user();

        $image->load([
            
            'comments' => function($query) {
                $query->with(['comments' => function($query) {
                    $query->with(['comments', 'user']); // Load comments of comments
                }, 'user']);
            },
            'tags'
        ]);

        $image->likes_count = $image->likes()->count();

        $comment_ids = [];
        foreach ($image->comments as $comment)
        {
            if($comment->id != null){
                array_push($comment_ids,$comment->id);
            }

            $child_comments = $this->get_like_ids($comment);
            if($child_comments != null){
                array_push($comment_ids,$child_comments);
            }
        }

        $comment_ids = Arr::flatten($comment_ids);

        // bulk query to prevent a lot of small queries from eager loading
        $likesCount = Like::where('likeable_type', 'App\Models\Comment')
            ->whereIn('likeable_id', $comment_ids)
            ->groupBy('likeable_id')
            ->selectRaw('likeable_id, COUNT(*) as likes_count')
            ->get()
            ->pluck('likes_count', 'likeable_id')
            ->toArray();

        $isLikedByUser = Like::where('likeable_type', 'App\Models\Comment')
            ->whereIn('likeable_id', $comment_ids)
            ->where('user_id', $user->id)
            ->get()
            ->pluck('id','likeable_id')
            ->toArray();
        
        foreach ($image->comments as $comment) {
            $comment->likes_count = $this->get_likes_count($comment, $likesCount);
            $comment->user_like_id = $this->get_user_like_id($comment, $isLikedByUser);
        }

        return view('images.show', compact('image'));
    }

    public function get_like_ids(Comment $comment){
        $ids = [];
        foreach ($comment->comments as $comment){
            if($comment->id != null){
                array_push($ids,$comment->id);
            }

            $child_comments = $this->get_like_ids($comment);
            if($child_comments != null){
                array_push($ids,$child_comments);
            }
        }
        return $ids;
    }
    
    public function get_likes_count(Comment $comment, $array)
    {
        foreach($comment->comments as $comment_child){
            $comment_child->likes_count = $this->get_likes_count($comment_child, $array);
        }
        return $array[$comment->id] ?? 0;
    }

    public function get_user_like_id(Comment $comment, $array)
    {
        foreach($comment->comments as $comment_child){
            $comment_child->user_like_id  = $this->get_user_like_id($comment_child, $array);
        }
        return $array[$comment->id] ?? 0;
    }
    
    public function edit(Image $image)
    {
        return view('images.edit', compact('blog'));
    }

    public function update(Request $request, Image $image)
    {
        $data = $request->validate([
            'description' => 'required|string|max:255'
        ]);
        
        $image->update($data);

        return redirect()->route('images.show',$image);
    }

}
