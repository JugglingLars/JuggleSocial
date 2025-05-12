<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'like' => 'required|bool',
            'parent_id' => 'required|integer',
            'parent_type' => 'required|string'
        ]);

        if($data['parent_type'] != 'App\Models\Image' &&$data['parent_type'] != 'App\Models\Comment' ){
            dd('hier');
            return redirect()->back()->with('error', 'Unknown parent type');
        }

        Like::create([
            'user_id' =>  Auth::id(),
            'likeable_id' => $data['parent_id'],
            'likeable_type' => $data['parent_type']
        ]);

        return redirect()->back();
    }

    public function destroy(Like $like)
    {
        if ($like->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You do not have permission to delete this like.');
        }

        $like->delete();

        return redirect()->back();
    }
}
