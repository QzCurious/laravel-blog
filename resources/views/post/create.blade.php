@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Post</h1>
        <form action="/posts" method="POST">
            @csrf

            <fieldset class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control">
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control"></textarea>
            </fieldset>
            <input type="submit" class="btn btn-primary" value="Publish">
        </form>
    </div>
@endsection
