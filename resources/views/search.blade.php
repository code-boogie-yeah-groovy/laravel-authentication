@extends('layouts.app')

@section('title')
  Search results
@endsection

@section('content')
<div class="container">
    @if(isset($details))
        <p> The Search results for your query <b> {{ $query }} </b> are :</p>
    <h2>Posts that match your search</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Post</th>
                <th>by</th>
                <th>on</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $post)
            <tr>
                <td>{{app('profanityFilter')->filter($post->body)}}</td>
                <td>{{$post->user->name}}</td>
                <td>{{ $post->created_at->format('M d, Y \a\t g:i A') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
      {{ $message }}
    @endif
</div>@endsection
