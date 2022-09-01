@foreach($comments as $comment)
    <div>
        <p>{{ $comment->comment }}</p>
        <p style="font-size:9px;">{{ date('M d, Y h:i A', strtotime($comment->created_at)) }}</p>
    </div>
@endforeach
