@extends('layouts.app') 
@section('title', 'home')
@section('content')
<style>
   a:hover {text-decoration:none;}
</style>
@if(count($posts))
    @foreach($posts as $post)
        <div class="panel panel-default">
            <div class="panel-heading"><h2>{{ $post->title }}</h2></div>
            <div class="panel-body">
                <a href="javascript:;">author <span class="badge">{{ $post->author->name }}</span></a> |
                <a href="javascript:;">topic <span class="badge">{{ $post->topic->name }}</span></a> |
                <a href="javascript:;">publish_at <span class="badge">{{ date("Y-m-d H:i", strtotime($post->created_at)) }}</span></a> 
                {{-- <a href="javascript:;">views <span class="badge">{{ $post->views }}</span></a> |
                <a href="javascript:;">stars <span class="badge">{{ $post->stars }}</span></a> |
                <a href="javascript:;">comments <span class="badge">{{ $post->comments }}</span></a>  --}}
            </div>
            <div class="panel-footer">
                <a href="{{ url('post/' . $post->id) }}" class="btn btn-info">read details</a>
            </div>
        </div>
    @endforeach
    {!! $posts->links() !!}
@endif
@endsection
