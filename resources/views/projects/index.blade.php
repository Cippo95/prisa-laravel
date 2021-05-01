@extends('layouts.app')

@section('content')
<div style="text-align:center">
    <h1>Progetti</h1>
        <ul>
        @foreach($projects as $project)
            <div class="">
                
                <li>{{ $project->id }}</li>
                
            </div>
        @endforeach
    </ul>
    </div>
</div>
@endsection