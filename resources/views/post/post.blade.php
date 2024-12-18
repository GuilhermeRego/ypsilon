<div class="post mb-3">
    <div class="row">
        <div class="col-md-10">
            <div class="post-body">
                <!-- If the user id is null, it is anonymous, otherwise, display the username -->
                <div class="post-author d-flex flex-row align-items-center">
                    @if ($post->user_id == null)
                        <h5 class="post-username">Anonymous</h5>
                    @else
                        <a href="{{ route('profile.show', ['username' => $post->user->username]) }}"
                            class="btn btn-outline-primary btn-sm mb-0" style="font-size: 1.5em">
                            {{ $post->user->nickname }}</a>
                        <p class="m-0 pl-1">&#64{{ $post->user->username}}</p>
                    @endif
                </div>
                <a href="{{ route('post.show', ['post' => $post->id]) }}" class="post-content"
                    style="text-decoration: none; color: black;">
                    <div>{!! $post->content !!}</div>
                    <p class="post-date"><small class="text-muted">{{ $post->date_time }}</small></p>
                </a>
            </div>
        </div>
        <div class="col-md-2 post-stats">
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm mb-0"><i
                        class="bi bi-hand-thumbs-up"></i> {{ $post->likesCount() }}</a>
                <a href="{{ route('login') }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-hand-thumbs-down"></i>
                    {{ $post->dislikesCount() }}</a>
            @endguest
            @auth
                <form action="{{ route('reaction.store') }}" method="POST" class="d-inline reaction-form">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="is_like" value="true">
                    <button type="submit" class="btn btn-outline-primary btn-sm mb-0" @if ($post->group && !auth()->user()->can('isMember', $post->group)) disabled style="pointer-events: none;" @endif>
                        <i class="bi bi-hand-thumbs-up"></i> {{ $post->likesCount() }}
                    </button>
                </form>

                <form action="{{ route('reaction.store') }}" method="POST" class="d-inline reaction-form">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <input type="hidden" name="is_like" value="false">
                    <button type="submit" class="btn btn-outline-danger btn-sm" @if ($post->group && !auth()->user()->can('isMember', $post->group)) disabled style="pointer-events: none;" @endif>
                        <i class="bi bi-hand-thumbs-down"></i> {{ $post->dislikesCount() }}
                    </button>
                </form>
                @if($post->group_id === null)
                    @if(!auth()->user()->savedPosts()->where('post_id', $post->id)->exists())
                        <form action="{{ route('saved.create', ['post' => $post->id]) }}" method="POST"
                            class="d-inline reaction-form">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark btn-sm"><i class="bi bi-floppy"></i></button>
                        </form>
                    @else
                        <form action="{{ route('saved.destroy', ['post' => $post->id]) }}" method="POST"
                            class="d-inline reaction-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-dark btn-sm"><i class="bi bi-floppy-fill"></i></button>
                        </form>
                    @endif
                @endif


            @endauth
            <span><i class="bi bi-arrow-repeat"></i> {{ $post->repostsCount() }}</span>
            <span class="mb-2"><i class="bi bi-chat"></i> {{ $post->commentsCount() }}</span>
        </div>
        @auth
            @if (auth()->check() && auth()->user()->id == $post->user_id || auth()->user()->isAdmin())
                <div class="post-edit">
                    <a href="{{ route('post.edit', ['post' => $post->id]) }}" class="btn btn-outline-primary btn-sm mb-0"><i
                            class="bi bi-pencil-square"></i> Edit</a>
                </div>
                <div class="post-delete">
                    <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
                    </form>
                </div>
            @endif
            @if (auth()->user()->id != $post->user_id)
                <div class="post-report">
                    <a href="{{ route('report.post', ['post' => $post->id]) }}" class="btn btn-outline-danger btn-sm"><i
                            class="bi bi-flag"></i> Report
                    </a>
                </div>
            @endif
        @endauth
    </div>
</div>