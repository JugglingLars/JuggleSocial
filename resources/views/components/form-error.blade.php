@props(['name'])
@error( $name )
    <span class="text-red-500">{{ $message }}</span>
@enderror