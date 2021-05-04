@extends('layouts.app')

@section('content')
<div style="text-align:center">
    {{-- @if(Auth::user()->role==2)
    <h1>Seleziona il corso per cui vuoi fare un nuovo progetto:</h1>
    <form action="/users/{{ Auth::user()->id }}/projects/create" method="post">
        @csrf
            @foreach($courses as $course)
                <input type="radio" id={{ $course->id }} name="course-id" value={{ $course->id }}>
                <label for={{ $course->id }}>{{ $course->name }}</label><br>
            @endforeach
            <input type="submit" value="Submit">
    </form>
    @elseif(Auth::user()->role==1) --}}
    <h1>Seleziona il corso di cui vuoi controllare i progetti:</h1>
    <ul>
        @foreach($courses as $course)
        <li>
            <a href="/courses/{{ $course->id }}/projects">{{ $course->name }}</a>
        </li>
        @endforeach
    </ul>
    {{-- @endif --}}
</div>
@endsection