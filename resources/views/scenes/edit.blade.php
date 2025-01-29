@extends('admin.index')

@section('content')
    <div class="container">
        <h1>Edit Scene</h1>
        <form action="{{ route('scenes.update', $scene->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Scene Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $scene->name }}" required>
            </div>
            <button type="submit" class="btn btn-warning mt-3">Update Scene</button>
        </form>
    </div>
@endsection
