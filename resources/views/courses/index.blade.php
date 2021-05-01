@extends('layouts.app')

@section('content')
<div style="text-align:center">
<ul>
    @foreach($courses as $course)
    <li>
        {{ $course->name }}
    </li>
    @endforeach
</ul>
</div>
@endsection