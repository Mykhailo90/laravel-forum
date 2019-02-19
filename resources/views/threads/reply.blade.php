<div class="card">
    <div class="card-header">
        <div class="level">
            <a href="#">
                {{ $reply->owner->name }}
            </a>
            said {{ $reply->created_at->diffForHumans() }} ...

            <div>
                <form method="POST" action="/replies/{{$reply->id}}/favorites">
                    {{ csrf_field() }}
{{--                    {{dd($reply->isFavorited())}}--}}
                    <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ str_plural('like', $reply->favorites_count)  }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
