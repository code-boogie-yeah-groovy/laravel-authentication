<section class="row posts">
  <div class="col-md-6 col-md-offset-3">
    <header><h3>{{ $section }}</h3></header>
    @foreach($posts as $post)
    <article class="post" data-postid="{{ $post->id }}" data-points="{{ $post->votes->where('vote',1)->count() - $post->votes->where('vote', 0)->count() }}">
      <div class="info">
        <img src="{{ $post->user->avatar }}" class="avatar-thumbnail img-responsive">
        <a href="{{ route('account', ['user_id' => $post->user_id]) }}">{{ $post->user->name }} </a>posted this on {{ $post->created_at->format('M d, Y \a\t g:i A') }}
      </div>
      <div class="post-media">
        @if($post->type == 'image')
        <img src="{{ $post->url }}" class="post-image"/>
        @elseif($post->type == 'video')
        <video width="400" class="post-video" controls>
          <source src="{{ $post->url }}" type="video/mp4">
          <source src="{{ $post->url }}" type="video/webm">
          <source src="{{ $post->url }}" type="video/ogv">
          Your browser does not support HTML5 video.
        </video>
        @endif
      </div>
      <div class="post-text">
        <p>{{ app('profanityFilter')->filter($post->body) }}</p>
      </div>
      <div class="post-points">
        <span id="points_{{ $post->id }}" class="points badge badge-default">{{ $post->votes->where('vote',1)->count() - $post->votes->where('vote', 0)->count() }}</span>
        <span class="info">&nbsp;points</span>
      </div>
      <div class="interactions" id="options_{{ $post->id }}">
        <a href="#" class="vote btn btn-default">
          @if(in_array($post->id,$upVotes))
            You upvoted this post
          @else
            Upvote
          @endif
        </a>
        <a href="#" class="vote btn btn-default">
          @if(in_array($post->id,$downVotes))
            You downvoted this post
          @else
            Downvote
          @endif
        </a>
        <a href="javascript:toggleDiv('comments_div{{ $post->id }}');" class="comment btn btn-default">
            Comments
            <span class="points badge badge-default">{{ $post->comments->where('commentable_id', $post->id)->count() }}</span>
        </a>
        @if(Auth::user() == $post->user)
        <a href="#" class="edit-post btn btn-default">Edit</a>
        <a href="#" class="delete-post btn btn-default" data-toggle="modal" data-target="#deleteModal">Delete</a>
        @endif
        @if(Auth::user() != $post->user)
        <a href="#" class="report btn btn-default">Report this post</a>
        @endif
      </div>
      <div class="comments_div" id="comments_div{{ $post->id }}">
        @foreach($comments as $comment )
          @if($post->id == $comment->commentable_id)
            @include('includes.comment-block')
          @endif
        @endforeach
        <div class="write-comment">
          <input type="text" name="comment"  id="comment_body{{ $post->id }}">
          <a href="#" class="post-comment">Post Comment</a>
          <input type="hidden" value="{{ Session::token() }}" name="_token">
        </div>
      </div>
    </article>
    @endforeach
  </div>
</section>
