@extends('layouts.base-tailwind')

@section('title', trans('messages.home'))

@section('app')
    <div class="hero min-h-[500px]" style="background-image: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}');">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-white">
            <div class="max-w-md">
                <h1 class="mb-5 text-5xl font-bold">{{ trans('messages.welcome', ['name' => site_name()]) }}</h1>

                @if($server)
                    @if($server->isOnline())
                        <h2 class="mb-5 text-2xl">{{ trans_choice('messages.server.online', $server->getOnlinePlayers()) }}</h2>
                    @else
                        <h2 class="mb-5 text-2xl">{{ trans('messages.server.offline') }}</h2>
                    @endif

                    @if($server->join_url)
                        <a href="{{ $server->join_url }}" class="btn btn-secondary btn-lg">
                            {{ trans('messages.server.join') }}
                        </a>
                    @else
                        <h3 class="text-xl">{{ $server->fullAddress() }}</h3>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        @include('elements.session-alerts')

        @if($message)
            <div class="alert alert-info mb-8">
                <span>{{ $message }}</span>
            </div>
        @endif

        @if(! $servers->isEmpty())
            <h2 class="text-3xl font-bold text-center mb-8">
                {{ trans('messages.servers') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                @foreach($servers as $server)
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body text-center">
                            <h3 class="card-title justify-center">
                                {{ $server->name }}
                            </h3>

                            @if($server->isOnline())
                                <div class="mb-2">
                                    <progress class="progress progress-primary w-full" value="{{ $server->getPlayersPercents() }}" max="100"></progress>
                                </div>

                                <p class="mb-4">
                                    {{ trans_choice('messages.server.total', $server->getOnlinePlayers(), [
                                        'max' => $server->getMaxPlayers(),
                                    ]) }}
                                </p>
                            @else
                                <p>
                                    <span class="badge badge-error">
                                        {{ trans('messages.server.offline') }}
                                    </span>
                                </p>
                            @endif

                            @if($server->join_url)
                                <div class="card-actions justify-center">
                                    <a href="{{ $server->join_url }}" class="btn btn-primary">
                                        {{ trans('messages.server.join') }}
                                    </a>
                                </div>
                            @else
                                <p class="text-sm">{{ $server->fullAddress() }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(! $posts->isEmpty())
            <h2 class="text-3xl font-bold text-center mb-8">
                {{ trans('messages.news') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($posts as $post)
                    <div class="card bg-base-100 shadow-xl">
                        @if($post->hasImage())
                            <figure>
                                <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full h-64 object-cover">
                            </figure>
                        @endif
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="{{ route('posts.show', $post) }}" class="link link-hover">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p>{{ Str::limit(strip_tags($post->content), 250) }}</p>
                            <div class="card-actions justify-between items-center mt-4">
                                <div class="text-sm opacity-70">
                                    {{ trans('messages.posts.posted', ['date' => format_date($post->published_at), 'user' => $post->author->name]) }}
                                </div>
                                <a class="btn btn-primary btn-sm" href="{{ route('posts.show', $post) }}">
                                    {{ trans('messages.posts.read') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
