<hr data-commentId="{{ $comment->id }}">
<div class="comment" data-commentId="{{ $comment->id }}" id="sortable" class="list-unstyled ui-sortable">
    <strong class="pull-left primary-font">
      <img src="{{ $comment->author->avatar }}" class="avatar-thumbnail img-responsive">
      <a href="#">{{ $post->user->name }}</a>
    </strong>
    <small class="pull-left text-muted">
      <span class="glyphicon glyphicon-time"></span>{{ $comment->created_at->format('M d, Y \a\t g:i A') }}
    </small>
    </br>
      <span class="ui-state-default">{{ $comment->body }}</span>
    </br>
</div>
