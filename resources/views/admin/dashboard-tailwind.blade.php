@extends('admin.layouts.admin-tailwind')

@section('title', trans('admin.dashboard.title'))

@section('content')
    <!-- Alerts -->
    @if(! $secure)
        <div id="notHttpsAlert" class="alert alert-warning shadow-lg mb-4">
            <div>
                <i class="bi bi-exclamation-triangle"></i>
                <span>{{ trans('admin.dashboard.http') }}</span>
            </div>
        </div>
        <div id="proxyAlert" class="alert alert-info shadow-lg mb-4 hidden">
            <div>
                <i class="bi bi-info-circle"></i>
                <span>{{ trans('admin.dashboard.cloudflare') }}</span>
            </div>
        </div>
    @endif

    @if(config('mail.default') === 'array')
        <div class="alert alert-warning shadow-lg mb-4">
            <div>
                <i class="bi bi-info-circle"></i>
                <span>@lang('admin.dashboard.emails', ['url' => route('admin.settings.mail')])</span>
            </div>
        </div>
    @endif

    @if($newVersion !== null)
        <div class="alert alert-info shadow-lg mb-4">
            <div>
                <i class="bi bi-plus-lg"></i>
                <span>
                    {{ trans('admin.dashboard.update', ['version' => $newVersion]) }}.
                    <a href="{{ route('admin.update.index') }}" class="link link-hover underline">
                        {{ trans('messages.actions.install') }}
                    </a>.
                </span>
            </div>
        </div>
    @endif

    @foreach($apiAlerts as $alertLevel => $alertMessage)
        <div class="alert alert-{{ $alertLevel }} shadow-lg mb-4">
            <div>{!! $alertMessage !!}</div>
        </div>
    @endforeach

    <!-- Stats Row -->
    <div class="stats stats-vertical lg:stats-horizontal shadow w-full mb-8">
        <div class="stat">
            <div class="stat-figure text-primary">
                <i class="bi bi-people text-3xl"></i>
            </div>
            <div class="stat-title">{{ trans('admin.dashboard.users') }}</div>
            <div class="stat-value text-primary">{{ $userCount }}</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <i class="bi bi-newspaper text-3xl"></i>
            </div>
            <div class="stat-title">{{ trans('admin.dashboard.posts') }}</div>
            <div class="stat-value text-secondary">{{ $postCount }}</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-accent">
                <i class="bi bi-file-earmark text-3xl"></i>
            </div>
            <div class="stat-title">{{ trans('admin.dashboard.pages') }}</div>
            <div class="stat-value text-accent">{{ $pageCount }}</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-info">
                <i class="bi bi-image text-3xl"></i>
            </div>
            <div class="stat-title">{{ trans('admin.dashboard.images') }}</div>
            <div class="stat-value text-info">{{ $imageCount }}</div>
        </div>
    </div>

    <!-- Activity Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="bi bi-people-fill"></i>
                    {{ trans('admin.dashboard.recent-users') }}
                </h2>
                
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>{{ trans('messages.fields.name') }}</th>
                                <th>{{ trans('messages.fields.email') }}</th>
                                <th>{{ trans('messages.fields.date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-8 h-8">
                                                    <img src="{{ $user->getAvatar() }}" alt="{{ $user->name }}" />
                                                </div>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.users.edit', $user) }}" class="link link-hover font-bold">
                                                    {{ $user->name }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="text-sm opacity-70">{{ format_date($user->created_at, true) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center opacity-60">
                                        {{ trans('messages.empty') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                        {{ trans('messages.actions.show') }}
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Latest Posts -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="bi bi-newspaper"></i>
                    {{ trans('admin.dashboard.recent-posts') }}
                </h2>

                <div class="space-y-3">
                    @forelse($latestPosts as $post)
                        <div class="flex items-start space-x-3 p-3 hover:bg-base-200 rounded-lg transition-colors">
                            @if($post->hasImage())
                                <div class="avatar">
                                    <div class="w-16 h-16 rounded">
                                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" />
                                    </div>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="link link-hover font-semibold block truncate">
                                    {{ $post->title }}
                                </a>
                                <div class="text-sm opacity-70 mt-1">
                                    <i class="bi bi-person-circle"></i>
                                    {{ $post->author->name }} • 
                                    <i class="bi bi-calendar3"></i>
                                    {{ format_date($post->published_at) }}
                                </div>
                            </div>
                            <div class="badge badge-{{$post->isPublished() ? 'success' : 'warning'}} badge-sm">
                                {{ $post->isPublished() ? trans('admin.posts.status.published') : trans('admin.posts.status.draft') }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center opacity-60 py-8">
                            {{ trans('messages.empty') }}
                        </div>
                    @endforelse
                </div>

                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
                        {{ trans('messages.actions.show') }}
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Section - Active Games -->
    @if(isset($activeGames) && ! $activeGames->isEmpty())
        <div class="card bg-base-100 shadow-xl mt-6">
            <div class="card-body">
                <h2 class="card-title">
                    <i class="bi bi-controller"></i>
                    {{ trans('admin.dashboard.active-games') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    @foreach($activeGames as $game)
                        <div class="stat bg-base-200 rounded-box">
                            <div class="stat-title">{{ $game->name }}</div>
                            <div class="stat-value text-sm">{{ $game->players_count }}</div>
                            <div class="stat-desc">{{ trans('admin.dashboard.players-online') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
