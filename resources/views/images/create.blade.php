
<x-layouts.app>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('images.store') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Description --}}
                        <x-form-field>
                            <x-form-label for="description">Description</x-form-label>
                            <x-form-textarea name="description" rows="4" required placeholder="Description of image"  />
                            <x-form-error name="description"/>
                        </x-form-field>

                        {{-- Image upload --}}
                        <x-form-field>
                            <x-form-label for="file">Upload file</x-form-label>
                            <x-form-input name="file" type="file" accept="image/png" required />
                            <x-form-error name="file"/>
                        </x-form-field>

                        {{-- Tags multi select --}}
                        {{-- <ul>
                            @foreach ($tags as $tag)
                                <li>{{ $tag->title }}</li>
                            @endforeach
                        </ul> --}}
                        {{-- <select name="cars" id="cars" multiple>
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->title }}">{{ $tag->title }}</option>
                            @endforeach
                          </select> --}}

                        
                          {{-- <label for="tag" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                          <select multiple id="tag" class="h-300 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->title }}">{{ $tag->title }}</option>
                            @endforeach
                          </select> --}}

                          <x-form-field>
                            <x-form-label for="tags[]">Tag(s)</x-form-label>
                            @foreach ($tags as $tag)
                            <input type="checkbox" name="tags[]" value="{{$tag->id}}"> <label>{{$tag->title}}</label>
                            @endforeach
                            <x-form-error name="tags[]"/>
                        </x-form-field>
                          {{-- <x-form-field>
                            <x-form-label for="tag">Select an tag</x-form-label>
                            <x-form-input name="image" type="file" accept="image/*" required />
                            <x-form-error name="image"/>
                        </x-form-field> --}}

                        
                        <button type="submit" class="w-auto h-10 lg:h-8 relative flex items-center gap-3 rounded-lg py-0 text-start px-3 my-px text-zinc-500 dark:text-white/80 data-[current]:text-[--color-accent-content] hover:data-[current]:text-[--color-accent-content] data-[current]:bg-white dark:data-[current]:bg-white/[7%] data-[current]:border data-[current]:border-zinc-200 dark:data-[current]:border-transparent hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5 border border-transparent">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>