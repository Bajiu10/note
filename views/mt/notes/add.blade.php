@extends('mt/layout/main')
@section('title')
    添加
@endsection
@section('head')
    <link rel="stylesheet" href="/static/editor/css/editormd.css"/>
@endsection
@section('body')
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 9)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center">
    </div>
    <main style="margin-top: -15em">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="container" style="flex-wrap: wrap">
                <div class="left" style="width:72%;">
                    <div class="card"
                         style="">
                        <div class="content"
                             style="padding:0 .5em">
                            <div id="form-header" style="display: flex;justify-content: space-around;margin: .5em 0;">
                                <input type="text" name="title" placeholder="标题">
                                <input type="text" name="tags" style="margin-right: 0" placeholder="标签[使用英文逗号分割]">
                            </div>
                            <div id="test-editor">
                                <textarea name="text" style="display:none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <aside>
                    <div class="card">
                        <div class="tips">摘要</div>
                        <div style="padding: .5em">
                            <input type="hidden" name="abstract" id="abstract-field">
                            <div id="abstract" contenteditable="true"
                                 style="width: 100%;min-height: 8em;box-sizing: border-box;resize: vertical;padding: .5em;border-radius: 2px;border: 1px solid #DDDDDD;outline: none;font-size: .8em"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="tips">分类</div>
                        <div style="padding: .5em">
                            <select name="cid" style="width: 100%;height: 2.5em">
                                @foreach($categories as $category)
                                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="tips">缩略图</div>
                        <div class="p-1" id="thumb-choose" style="cursor: pointer">
                            <div style="width:100%;min-height:5em;box-sizing: border-box;text-align: center"
                                 id="thumb-area">
                                <i class="fa fa-upload"
                                   style="color: black;display:block;width:100%;margin:3.5em auto"></i>
                            </div>
                        </div>
                        <input type="file" id="thumb" style="display: none">
                        <input type="hidden" name="thumb">
                    </div>
                    <div class="card">
                        <div class="tips">其他</div>
                        <div style="padding: .5em">
                            <label>
                                <input type="checkbox" name="permission" checked>公开
                            </label>
                        </div>
                    </div>
                    <input type="submit" class="btn-submit">
                </aside>
            </div>
        </form>
    </main>
@endsection
@section('js')
    <script src="/static/editor/editormd.min.js"></script>
    <script type="text/javascript">
        $(function () {
            var editor = editormd("test-editor", {
                // width  : "100%",
                height: "632px",
                path: "/static/editor/lib/",
                imageUpload: true,
                watch: true,
                autoFocus: false,
                imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                imageUploadURL: "/api/notes/uploadImage",
                toolbarIcons: function () {
                    // Or return editormd.toolbarModes[name]; // full, simple, mini
                    // Using "||" set icons align right.
                    return ["undo", "redo",
                        "bold", "del", "italic", "quote", "ucwords", "uppercase", "lowercase",
                        "h1", "h2", "h3", "h4", "h5", "h6",
                        "list-ul", "list-ol", "hr",
                        "link", "reference-link", "image", "code", "preformatted-text", "code-block", "table", "datetime", "html-entities",
                        "goto-line", "watch", "preview", "fullscreen", "clear", "search"]
                },
                placeholder: "请图文并茂地介绍下你的项目！",
            });

            $('#abstract').on('input', function () {
                $('#abstract-field').val($(this).text());
            });

            $('#thumb-choose').on('click', () => {
                $('#thumb').trigger('click');
            });
            $('#thumb').on('change', () => {
                var form = new FormData;
                form.append('thumb', $('#thumb')[0].files[0])
                $.ajax({
                    url: '/api/notes/upload-thumb',
                    type: 'post',
                    contentType: false,
                    processData: false,
                    data: form,
                    success: function (e) {
                        let img = `<img src="${e.path}" style="width: 100%;height: 100%;" id="show-thumb" alt="thumb">`;
                        $('[name=thumb]').val(e.path)
                        $('#thumb-area').html(img);
                    },
                    error: function (e) {
                        console.log(e)
                    }
                });
                // let thumb = window.URL.createObjectURL($('#thumb')[0].files[0]);
            });

            // $(document).on('scroll', function () {
            //     if ($(document).scrollTop() > 100) {
            //         $('header').css('background-color', 'black')
            //     } else {
            //         $('header').css('background-color', 'transparent')
            //     }
            // })

        });
    </script>
@endsection
