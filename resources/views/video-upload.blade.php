<!-- resources/views/admin/video-upload.blade.php -->

@extends('admin.index')  <!-- Assuming you're extending a main layout -->

@section('content')
<div class="container">
    <h2>Upload Animal Video</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Video Upload Form -->
    <form action="{{ route('videoUploads') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Animal Type -->
        <div class="mb-3">
            <label for="animal_type" class="form-label">Select Animal Type</label>
            <select class="form-control" name="animal_type" id="animal_type">
                <option value="">Select Animal</option>
                @foreach ($availableAnimalTypes as $animal)
                    <option value="{{ $animal }}" {{ old('animal_type') == $animal ? 'selected' : '' }}>{{ $animal }}</option>
                @endforeach
            </select>
            @error('animal_type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Video File -->
        <div class="mb-3">
            <label for="video_link" class="form-label">Video File</label>
            <input type="file" class="form-control" name="video_link" id="video_link">
            @error('video_link')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Language -->
        <div class="mb-3">
            <label for="language" class="form-label">Select Language</label>
            <select class="form-control" name="language" id="language">
                <option value="">Select Language</option>
                <option value="Hindi" {{ old('language') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>English</option>
            </select>
            @error('language')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Upload Video</button>
    </form>
</div>
@endsection
