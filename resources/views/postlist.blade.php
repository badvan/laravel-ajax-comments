@foreach($posts as $post)
    <div class="panel panel-default my-3">
        <div class="panel-body">
            <p class="small">{{ date('M d, Y h:i A', strtotime($post->created_at)) }}</p>
            <h2 CLASS="py-3">{{ $post->post }}</h2>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-info btn-sm comment" value="{{ $post->id }}">
                        <i class="fa fa-comments"></i> Комментировать
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="commentField_{{ $post->id }}" class="panel panel-default" style="display: none;">

        <div id="comment_{{ $post->id }}"></div>
        <button id="commentMore_{{ $post->id }}" class="btn btn-outline-warning btn-sm mb-3" style="display: none;">
            <span class="spinner-border spinner-border-sm" style="display: none;" role="status"></span>
            Показать ещё
        </button>

        <form id="commentForm_{{ $post->id }}">
            <input type="hidden" value="{{ $post->id }}" name="post_id">
            <div class="input-group mb-3">
                <input type="text" name="comment" class="form-control commenttext" placeholder="Напишите комментарий..." data-id="{{ $post->id }}" id="commenttext_{{ $post->id }}">
                <button class="btn btn-primary submitComment" type="button" value="{{ $post->id }}"><i class="fa fa-comment"></i> Сохранить</button>
            </div>
        </form>
    </div>
@endforeach
