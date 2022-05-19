@extends('mt.layout.main')
@section('body')
    <link rel="stylesheet" href="/static/editor/css/editormd.preview.css"/>
    <style>
        .note-list {
            padding: .2em;
            cursor: pointer;
            border-radius: 5px;
            transition: all .5s;
            font-size: .9em;
            line-height: 1.5em;
        }

        .note-list:hover {
            background-color: #e5e4e4;
        }
    </style>
    <main id="app" style="margin-top: 3.8em">
        <div style="padding: .5em">
            <h1>{{$book->name}}</h1>
        </div>
        <div>
            <aside style="width: 25%; display: inline-block; vertical-align: top" class="card">
                <ul style="list-style-type: none; padding: .5em;margin: 0">
                    @foreach($notes as $note)
                        <li class="note-list" data-id="{{$note->id}}">
                            {{$note->title}}
                        </li>
                    @endforeach
                </ul>
            </aside>
            <div id="test-editormd-view2" class="card" style="width: 70%; display: inline-block">
                <textarea id="append-test" style="display: none"></textarea>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script src="/static/editor/lib/marked.min.js"></script>
    <script src="/static/editor/lib/prettify.min.js"></script>
    <script src="/static/editor/lib/raphael.min.js"></script>
    <script src="/static/editor/lib/underscore.min.js"></script>
    <script src="/static/editor/lib/sequence-diagram.min.js"></script>
    <script src="/static/editor/lib/flowchart.min.js"></script>
    <script src="/static/editor/lib/jquery.flowchart.min.js"></script>
    <script src="/static/editor/editormd.min.js"></script>
    <script type="text/javascript" src="/static/js/qrcode.min.js" id="corepress_jquery_qrcode-js"></script>
    <script>
        let testEditormdView2;

        $('.note-list').click(function () {
            let id = $(this).attr('data-id')
            $.ajax({
                url: "/api/notes/" + id,
                dataType: "json",
                type: "GET",
                success(e) {
                    if (e.status === true) {
                        $('#test-editormd-view2').html('')
                        testEditormdView2 = editormd.markdownToHTML("test-editormd-view2", {
                            htmlDecode: "style,script,iframe",  // you can filter tags decode
                            emoji: false,
                            taskList: true,
                            tex: true,  // 默认不解析
                            flowChart: true,  // 默认不解析
                            markdown: e.data.text,
                            sequenceDiagram: true,  // 默认不解析
                        });
                    }
                }
            })
        })
    </script>
@endsection
