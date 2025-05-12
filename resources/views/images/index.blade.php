<x-layouts.app :title="__('images')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-end">
            <a href="{{ route('images.create') }}" class="w-auto h-10 lg:h-8 relative flex items-center gap-3 rounded-lg py-0 text-start px-3 my-px text-zinc-500 dark:text-white/80 data-[current]:text-[--color-accent-content] hover:data-[current]:text-[--color-accent-content] data-[current]:bg-white dark:data-[current]:bg-white/[7%] data-[current]:border data-[current]:border-zinc-200 dark:data-[current]:border-transparent hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5 border border-transparent">
                Add image
            </a>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @foreach ($images as $image)
                @php
                    $folder = Storage::disk('public')->exists('images/'. $image->image_full_name)?'images/':'temp/';
                    $liked_by_user = $image->user_like_id != 0;
                @endphp
                <a href="{{ route('images.show', $image->id) }}" class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                    <img src="{{ Storage::url($folder . $image->image_full_name) }}">

                    <p>{{ substr($image->description,0,50).'...' }}</p>
                    <x-likes-count likes="{{ $image->likes_count }}"/>
                    <p>comments: {{ $image->comments->count() }}</p>

                    @foreach ($image->tags  as $tag)
                        <x-tag>
                            {{ $tag->title }}
                        </x-tag>
                    @endforeach
                    
                    <div class="pb-4">
                        <x-btn-like liked="{{ $liked_by_user }}" liked_id="{{ $image->user_like_id }}"  parent_id="{{ $image->id }}" parent_type="App\Models\Image"/>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-layouts.app>
