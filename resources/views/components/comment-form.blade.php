@props([
    'parent_id',
    'parent_type'
])

<div class="border border-neutral-200 dark:border-neutral-700">
    <form method="POST" action="{{ route('comments.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $parent_id }}"/>
        <input type="hidden" name="parent_type" value="{{ $parent_type }}"/>
        <x-form-field>
            <x-form-label for="comment">Comment</x-form-label>
            <x-form-textarea name="comment" rows="4" required placeholder="Comment"  />
            <x-form-error name="comment"/>
        </x-form-field>
        
        <button type="submit" class="w-auto h-10 lg:h-8 relative flex items-center gap-3 rounded-lg py-0 text-start px-3 my-px text-zinc-500 dark:text-white/80 data-[current]:text-[--color-accent-content] hover:data-[current]:text-[--color-accent-content] data-[current]:bg-white dark:data-[current]:bg-white/[7%] data-[current]:border data-[current]:border-zinc-200 dark:data-[current]:border-transparent hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5 border border-transparent">
            Submit
        </button>
    </form>
</div>