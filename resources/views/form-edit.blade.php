@extends('layout.template')

@section('title', 'Edit Movie')

@section('content')

<h2 class="mb-4">Edit Movie</h2>

<form
    action="{{ route('movies.update', ['movie' => $movie->id]) }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    <div class="mb-3">
        <label for="id" class="form-label">ID Film:</label>

        <input
            type="text"
            class="form-control"
            id="id"
            value="{{ $movie->id }}"
            disabled
        >
    </div>

    @include('partials.movie-form')

</form>

@endsection