@extends('admin.index')

@section('content')
    <div class="container">
        <h1>Scenes</h1>
        <a href="{{ route('scenes.create') }}" class="btn btn-primary">Create New Scene</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scenes as $scene)
                    <tr>
                        <td>{{ $scene->id }}</td>
                        <td>{{ $scene->name }}</td>
                        <td>
                            <a href="{{ route('scenes.show', $scene->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('scenes.edit', $scene->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('scenes.destroy', $scene->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
