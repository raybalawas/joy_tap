@extends('admin.index')

@section('content')
    <div class="container">
        <h1>Scene Details</h1>
        <p><strong>Scene Name:</strong> {{ $scene->name }}</p>
        <a href="{{ route('scenes.index') }}" class="btn btn-primary">Back to Scenes</a>
    </div>
@endsection
