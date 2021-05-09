<h1>Insegnanti del corso</h1>
<a href="/courses/{{ $course }}/users/create">Clicca qui per aggiungere docenti al corso</a>
<table border="1" style="margin: 0px auto;"> 
    <tr>
        <td>ID</td>
        <td>Docente</td>
        <td>Rimuovi</td>
    </tr>
    @forelse($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td><a href= "/courses/{{ $course }}/users/{{ $user->id }}/delete">Rimuovi</a></td>
        {{-- <td><a href= "/courses/{{ $course->id }}/delete">Rimuovi</a></td> --}}
    </tr>
    @endforeach
</table>