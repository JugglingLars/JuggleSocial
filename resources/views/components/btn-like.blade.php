@props([
    'liked',
    'liked_id',
    'parent_id',
    'parent_type'
])
@php
    $method = $liked?'DELETE':'POST';
    $route = $liked?route('likes.destroy', $liked_id):route('likes.store');
    $like_value = $liked?'0':'1';
    $btn_text = 'Like'.($liked?'d':'');
    $btn_color = $liked?'bg-green-500 hover:bg-green-600':'bg-gray-500 hover:bg-gray-600';
@endphp

<form method="POST" action="{{ $route }}" enctype="multipart/form-data">
    @csrf
    @method($method)
    <input type="hidden" name="parent_id" value="{{ $parent_id }}"/>
    <input type="hidden" name="parent_type" value="{{ $parent_type }}"/>
    <input type="hidden" name="like" value="{{ $like_value }}"/>
    
    <button type="submit" class="flex items-center justify-center px-4 py-2 text-white rounded-full {{ $btn_color }}">
            <x-svg-like liked="{{ $liked }}"/>
    </button>
</form>