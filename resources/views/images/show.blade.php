<x-layouts.app :title="__('image')">
        <div class="grid auto-rows-min gap-4 lg:grid-cols-2">
                @php
                    $folder = Storage::disk('public')->exists('images/'. $image->image_full_name)?'images/':'temp/'
                @endphp
                <div>
                    <div class="relative rounded-xl border border-neutral-200 dark:border-neutral-700 p-2">
                        <img class="pb-4" src="{{ Storage::url($folder . $image->image_full_name) }}" alt="Image">

                        <p class="pb-4">{{ $image->description }}</p>
                        <x-likes-count likes="{{ $image->likes_count }}"/>
                        <p class="pb-4">comments: {{ $image->comments->count() }}</p>
                        @foreach ($image->tags  as $tag)
                        <x-tag>
                            {{ $tag->title }}
                        </x-tag>
                    @endforeach
                    </div>
                </div>
            <div>
                <x-comment-form parent_id="{{ $image->id }}" parent_type="App\Models\Image"/>
                @if (count($image->comments) > 0)
                    @each('components.comment', $image->comments, 'comment')
                @else
                    no comments
                @endif
            </div>
        </div>
        <script>
            var coll = document.getElementsByClassName("collapsible");

            for (var i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                    content.style.display = "none";
                    } else {
                    content.style.display = "block";
                    }
                });
            } 
        </script>
</x-layouts.app>
