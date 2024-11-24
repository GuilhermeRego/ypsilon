<div class="createpost mb-4">
    <div class="post">
        <div class="post-body">
            <form action="{{ route('post.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="date_time" value="{{ now() }}">
                <div class="form-group mb-3">
                    <textarea class="form-control" id="content" name="content" rows="3" required placeholder="Write something..."></textarea>
                </div>
                <input type="hidden" name="group_id" value="{{ isset($group) ? $group->id : null }}">
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
        </div>
    </div>
</div>