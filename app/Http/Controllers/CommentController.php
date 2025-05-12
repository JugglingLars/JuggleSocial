<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'comment' => 'required|string',
            'parent_id' => 'required|integer',
            'parent_type' => 'required|string'
        ]);
        
        if($data['parent_type'] != 'App\Models\Image' && $data['parent_type'] != 'App\Models\Comment' ){
            return redirect()->back()->with('error', 'Unknown parent type');
        }

        Comment::create([
            'user_id' =>  Auth::id(),
            'comment_text'=>$data['comment'],
            'comment_on_id' => $data['parent_id'],
            'comment_on_type' => $data['parent_type']
        ]);

        return redirect()->back();
    }
}
