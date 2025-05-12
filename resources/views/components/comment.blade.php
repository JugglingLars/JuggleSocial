@php
$liked_by_user = $comment->user_like_id != 0;
@endphp

<article class="p-6 border border-neutral-200 text-base rounded-lg dark:border-neutral-700">
    <footer class="flex justify-between items-center mb-2">
        <div class="flex items-center">
            <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold">
                {{ $comment->user->name }}
            </p>
        </div>
    </footer>
    <p class="text-gray-500 dark:text-gray-400">
        {{ $comment->comment_text }}
    </p>
    <div class="flex flex-col mt-4 space-x-4 vertical-align">
        <div>
            <x-likes-count likes="{{ $comment->likes_count }}"/>
            <div class="pb-4">
                <x-btn-like liked="{{ $liked_by_user }}" liked_id="{{ $comment->user_like_id }}"
                    parent_id="{{ $comment->id }}" parent_type="App\Models\Comment" />
            </div>
        </div>
        <button type="button"
            class="collapsible flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
            <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
            </svg>
            Reply
        </button>
        <div class="hidden">
            <x-comment-form parent_id="{{ $comment->id }}" parent_type="App\Models\Comment" />
        </div>
    </div>

    @if($comment->comments->count() > 0)
        @each('components.comment', $comment->comments, 'comment')
    @endif
</article>