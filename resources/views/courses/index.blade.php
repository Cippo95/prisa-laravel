{{-- student welcome page --}}
@extends('layouts.app')

@section('content')
{{-- <div class="flex-center position-ref full-height">
</div> --}}

{{-- Qui dovrò mostrare i corsi dello studente --}}
<ul>
    @foreach($courses as $course)
    <li>
        {{ $course->name }}
    <li>
</ul>
@endforeach
@endsection