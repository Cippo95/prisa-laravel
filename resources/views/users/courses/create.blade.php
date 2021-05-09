@extends('layouts.app')
@section('content')
<div style="text-align:center">
    <h1>Segui Corso</h1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="/home">Clicca qui per tornare alla home.</a><br><br>
                    <label for="course">Scegli un corso che segui:</label><br>
                    <form action="/users/{{ Auth::user()->id }}/courses/" method="POST">
                        @csrf
                        <select name="course" id="course">
                            @foreach ($courses as $course)
                                <option value={{ $course->id }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                        <input type="submit" value="Conferma">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection