<div class="col-md-3">
    <a href="{{ url('post') }}" class="btn btn-default">write</a>
    @if(!Auth::guest() && isset($updateSign) && $updateSign && isset($post) && Auth::user()->can('update-post', $post))
        <a href="{{ url('post/' . $post->id . '/update') }}" class="btn btn-default">edit</a>
    @endif
    <hr />
    <h3>topics clouds</h3>
    @if(count($topicsLists))
        @foreach($topicsLists as $topicsList)
            <a style="margin:4px;" class="btn btn-primary" href="{{ url('posts/topic/' . $topicsList->id) }}">
                {{ $topicsList->name }} <span class="badge">{{ $topicsList->post_number }}</span>
            </a>
        @endforeach
    @endif
</div>