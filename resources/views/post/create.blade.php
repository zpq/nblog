@extends('layouts.app')
@section('title', 'new post')
@section('content')
@include('editor::head')
<style media="screen">
.row{
    margin-left:0px;
    margin-right:0px;
}
</style>

    <div class="row">
        <div class="col-md-10 col-md-offset-1 ">
            <h1>create a new post</h1>
            {{-- <div class="panel panel-default">
                <div class="panel-heading">create a new post</div>
                <div class="panel-body"> --}}
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/post') }}">
                        {{ csrf_field() }}
                        <div class="col-md-11 form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title">title</label>
                            <input id="title" type="text" class="form-control" name="title" placeholder="input a title">
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-11 form-group{{ $errors->has('topic') ? ' has-error' : '' }}">
                            <label for="topic">topic</label>
                            <input id="topic" type="text" class="form-control" name="topic" placeholder="input a topic or choose a exist topic from below selection">
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

                        <div class="editor col-md-10">
                            <textarea name="content" id='myEditor'></textarea>
                        </div>

                        <div class="form-group">
                            <div class="col-md-2 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> post
                                </button>
                            </div>
                        </div>
                    </form>
                {{-- </div>
            </div>
        </div> --}}
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
