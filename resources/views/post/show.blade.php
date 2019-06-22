@extends('layouts.app')

@section('content')
    <div class="container">
        <article>
            <header>
                <h1>{{ $post->title }}</h1>
            </header>
            <section>{{ $post->content }}</section>
        </article>
    </div>
@endsection
