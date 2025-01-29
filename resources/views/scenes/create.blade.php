@extends('admin.index')

@section('content')
    <div class="container">
        <h1>Create New Scene</h1>
        <form action="{{ route('scenes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Scene Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Create Scene</button>
        </form>
    </div>
@endsection
