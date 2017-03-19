<hr data-commentId="{{ $comment->id }}">
<div class="comment" data-commentId="{{ $comment->id }}" id="sortable" class="list-unstyled ui-sortable">
    <strong class="">
      <img src="{{ $comment->author->avatar }}" class="avatar-thumbnail img-responsive">
      <a href="{{ route('account', ['user_id' => $post->user->id]) }}">{{ $post->user->name }}</a>
    </strong>
    <small class="text-muted">
      {{ $comment->created_at->format('M d, Y \a\t g:i A') }}
    </small>
    <div class="comment-text">
      <p>{{ $comment->body }}</p>
    </div>
    </br>
</div>
