@extends('layouts.app')

@section('content')
WORK IN PROGRESSSSSSS
<div style="text-align:center">
    <h1>Allegati</h1>
        <ul>
        @foreach($attachments as $attachment)
            <div class="">
                <li> {{ $attachment->user_id }} {{ $attachment->message }}</li>
            </div>
        @endforeach
    </ul>
    </div>
</div>
@endsection