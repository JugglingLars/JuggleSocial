@props([
    'likes'
])

<p>{{ $likes }} Like{{ ($likes!=1?'s':'') }}</p>