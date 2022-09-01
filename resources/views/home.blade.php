@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <h1 class="page-header">Сообщения пользователя с использованием AJAX</h1>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form id="postForm">
                            <textarea class="form-control" name="post" id="post"
                                      placeholder="О чём ты хотел бы поговорить?"></textarea>
                            <button type="button" id="postBtn" class="btn btn-success mt-2">
                                <i class="fa-solid fa-message"></i> Добавить
                            </button>
                        </form>
                    </div>
                </div>
                <div class="my-3" id="postList"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        let page = 1;

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            showPost();

            $('#postBtn').click(function () {
                let post = $('#post').val();
                if (post == '') {
                    alert('Please write a Post first!');
                    $('#post').focus();
                } else {
                    let postForm = $('#postForm').serialize();
                    $.ajax({
                        type: 'POST',
                        url: '/post',
                        data: postForm,
                        dataType: 'json',
                        success: function () {
                            showPost();
                            $('#postForm')[0].reset();
                        },
                    });
                }
            });

            $(document).on('click', '.comment', function () {
                let id = $(this).val();
                if ($('#commentField_' + id).is(':visible')) {
                    $('#commentField_' + id).slideUp();
                } else {
                    $('#commentField_' + id).slideDown();
                    getComment(id);
                }
            });

            $(document).on('click', '.submitComment', function () {
                let id = $(this).val();

                if ($('#commenttext_' + id).val() == '') {
                    alert('Please write a Comment First!');
                } else {
                    let commentForm = $('#commentForm_' + id).serialize();

                    $.ajax({
                        type: 'POST',
                        url: 'writecomment',
                        data: commentForm,
                        success: function () {
                            getComment(id);
                            $('#commentForm_' + id)[0].reset();
                            $('#commentMore_' + id).prop('disabled', false)
                            page = 1;
                        },
                    });
                }
            });
        });

        // Получение постов
        function showPost() {
            $.ajax({
                url: '/show',
                success: function (data) {
                    $('#postList').html(data);
                },
            });
        }

        // Получение комментариев
        function getComment(id) {
            $.ajax({
                url: 'getcomment',
                data: {id: id},
                success: function (data) {
                    if (data.length > 0) {
                       $('#commentMore_' + id).show();
                    }

                    $('#comment_' + id).html(data);
                }
            });
        }

        $(document).on('click', '[id^="commentMore_"]', function () {
            let id = $(this).attr('id')
            id = id.split('commentMore_').join("")
            page++

            load_more(id, page)

            function load_more(id, page) {
                $.ajax({
                    url: "/getcomment?page=" + page,
                    type: "get",
                    data: {id: id},
                    beforeSend: function () {
                        $('.spinner-border').show();
                    },
                    success: function (data) {

                        if (data.length == 0) {
                            $('#commentMore_' + id).prop('disabled', true)
                        }

                        $('#comment_' + id).append(data);
                        $('.spinner-border').hide();
                    }
                })
            }
        });
    </script>
@endsection
