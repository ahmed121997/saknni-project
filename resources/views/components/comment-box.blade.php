<div class="display-comment">
    <strong class="mt-1">
        <img src="{{ $comment->user->avatar }}" class="mx-1" style="width: 40px;height: 40px;border-radius: 50%;"/>
        {{ $comment->user->name }}
    </strong>
    <p>{{ $comment->body }}</p>

    @if(Auth::check() && $comment->user_id == auth()->id())
        <div>
            <small class="text-info mx-4">{{ $comment->created_at->format('d M Y, h:i a') }}</small>
            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm">
                    <i class="far fa-trash-alt text-danger"></i>
                </button>
            </form>
        </div>
    @else
        <div>
            <small class="text-info">{{ $comment->created_at->format('d M Y, h:i a') }}</small>
        </div>
    @endif
</div>
