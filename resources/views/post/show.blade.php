@extends("layouts.app") 
@section('title')
    {{ $post->title }}
@endsection
@section('content')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.6.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.6.0/highlight.min.js"></script>
<script>
    hljs.initHighlightingOnLoad();
</script>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <h2>{{ $post->title }}</h2>
                <h4>author : {{ $post->author->name }} | topic : <a href="{{ url('posts/topic/' . $post->topic->id) }}">{{ $post->topic->name }}</a> |  publish_at : {{ $post->updated_at }}</h4>
                <h4><a href="javascript:;">views <span class="badge">{{ $post->views }}</span></a> |
                <a href="javascript:;">stars <span class="badge">{{ $post->stars }}</span></a> |
                <a href="javascript:;">comments <span class="badge">{{ $post->comments }}</span></a> </h4>
            </div>
            <div class="panel-body">
                <article>
                    <?= $post->content ?>
                </article>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-success">star</button>
            </div>
        </div>
    </div>
</div>

@stop