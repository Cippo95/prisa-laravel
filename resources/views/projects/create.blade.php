<h1>Seleziona un corso e scrivi il messaggio iniziale.</h1>
    <form action="/users/{{ Auth::user()->id }}/projects" method="post">
        @csrf
        <label for="course">Scegli un corso:</label>
        <select name="course" id="course">
            @foreach($userCourses as $userCourse)
            <option value={{ $userCourse->id }}>{{ $userCourse->name }}</option>
            @endforeach
        </select>
        <br><br>
        <label for="message">Aggiungi un messaggio:</label>
        <br>
        <textarea name="message" id="message" cols="30" rows="10" placeholder="Scrivi un messaggio..."></textarea>
        <br>
        <input type="submit" value="Submit">
    </form>







{{-- <form action="/users/{{ Auth::user()->id }}/projects/create" method="post">
        @csrf
            @foreach($courses as $course)
                <input type="radio" id={{ $course->id }} name="course-id" value={{ $course->id }}>
                <label for={{ $course->id }}>{{ $course->name }}</label><br>
            @endforeach
            <input type="submit" value="Submit">
    </form>
</form> --}}