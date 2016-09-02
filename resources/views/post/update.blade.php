@extends('layouts.app')
@section('title', 'update post')
@section('content')
@include('editor::head')
<style media="screen">
.row{
    margin-left:0px;
    margin-right:0px;
}
</style>

<div class="row">
    <div class="col-md-12">
        <h1>update a post</h1>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/posts/update') }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $post->id }}">
            <div class="col-md-11 form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title">title:</label>
                <input id="title" type="text" class="form-control" name="title" value="{{ $post->title }}" placeholder="input a title">
                @if ($errors->has('title'))
                    <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>

            <div class="col-md-6 form-group{{ $errors->has('topic') ? ' has-error' : '' }}">
                <label for="topic">topic:</label>
                <input id="topic" type="text" class="form-control" name="topic" value="{{ $post->topic->name }}" placeholder="input a topic or choose a exist topic from below selection">
                @if ($errors->has('topic'))
                    <span class="help-block">
                        <strong>{{ $errors->first('topic') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group col-md-11">
                <select class="form-control" name="topics">
                    <option selected="selected" value="">you may choose a topic from here</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group editor col-md-12">
                <textarea name="content" id='myEditor'> {{ $post->content }} </textarea>
            </div>

            <div class="form-group">
                <div class="col-md-2 col-md-offset-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> post
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $("select[name='topics']").change(function() {
        var topics = $(this).val();
        if (topics !== '') {
            $("#topic").val($("select[name='topics'] option:selected").text());
        }
    });

</script>

@endsection
