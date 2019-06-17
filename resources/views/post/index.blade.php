@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Posts</h1>
        @foreach($posts as $post)
            <article>
                <header>
                    <h1 class="h2">{{ $post->title }}</h1>
                </header>
                <section>{{ $post->content }}</section>
            </article>
        @endforeach
    </div>
@endsection
