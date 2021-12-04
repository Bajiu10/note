@extends('mt/layout/main')
@section('title')
    修改
@endsection
@section('head')
    <link rel="stylesheet" href="/static/editor/css/editormd.css"/>
@endsection
@section('body')
    <div style="height:20em;background: url('/static/bg/bg{{rand(1, 9)}}.jpg') no-repeat center center;display: flex; justify-content: center; align-items: center">
    </div>
    <main style="margin-top: -15em">
        <form action="{{url('edit',[$note['id']])}}" method="post" enctype="multipart/form-data">
            <div class="container" style="flex-wrap: wrap">
                <div class="left" style="width:72%;">
                    <div class="card"
                         style="">
                        <div class="content"
                             style="padding:0 1em">

                            <div style="display: flex;justify-content: space-around;margin: .5em 0">
                                <input type="text" name="title" value="{!! $note['title'] !!}" placeholder="标题"
                                       style="width:49%;padding-left:.5em;height: 2.5em;outline: none;border: 1px solid #DDDDDD;border-radius: 0;margin-right: .5em">
                                <input type="text" name="tags" value="{{$note['tags']}}" placeholder="标签[使用英文逗号分割]"
                                       style="width:49%;padding-left:.5em;height: 2.5em;outline: none;border: 1px solid #DDDDDD;border-radius: 0">
                            </div>
                            <div id="test-editor">
                            <textarea name="text" id="" cols="30" rows="10"
                                      style="display:none;">{!! $note['text'] !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <aside>
                    <div class="card">
                        <div class="tips2">摘要</div>
                        <div style="padding: .5em">
                        <textarea name="abstract" rows="7"
                                  style="width: 100%;height: 100%;box-sizing: border-box;resize: vertical;padding: .5em;border: 1px solid #DDDDDD;outline: none">{!! $note['abstract'] !!}</textarea>
                        </div>
                    </div>
                    <div class="card">
                        <div class="tips2">分类</div>
                        <div style="padding: .5em">
                            <select name="cid" style="width: 100%;height: 2.5em">
                                @foreach($categories as $key => $category)
                                    <option value="{{$category['id']}}"
                                            @if($category['id']== $note['cid'])
                                            selected
                                            @endif
                                    >{{$category['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card">
                        <div class="tips2">缩略图</div>
                        <div class="p-1">
                            <div style="width:100%;min-height:5em;box-sizing: border-box;text-align: center"
                                 id="thumb-area">
                                @if(!empty($note['thumb']))
                                    <img src="{{$note['thumb']}}" style="width: 100%;height: 100%;" id="show-thumb"
                                         alt="thumb">
                                @endif
                                <a href="javascript:void(0)" id="thumb-choose"
                                   style="display:block;width:100%;margin:3.5em auto"><i class="fa fa-upload"
                                                                                         style="color: black"></i></a>
                            </div>
                            <input type="file" id="thumb" style="display: none">
                            <input type="hidden" name="thumb" value="{{$note['thumb']}}">
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
