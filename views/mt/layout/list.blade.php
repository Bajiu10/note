<div class="content">
    @foreach($notes as $note)
        <div class="list-item">
            <div>
                <a href="/note/{{$note['id']}}.html" target="_blank">
                    <img id="thumb" data-original="{{$note['thumb']}}" alt="">
                </a>
            </div>
            <div class="list-content">
                <div>
                    <div class="list-content-title">
                        <a target="_blank" class="article-title"
                           href="/note/{{$note['id']}}.html">@if(0 != $note['permission']) <i class="fa fa-lock" aria-hidden="true"></i> @endif {{$note['title']}}</a>
                    </div>
                    <div class="description">
                        {{$note['abstract']}}
                    </div>
                </div>
                <div class="list-content-bottom">
                            <span><i class="fa fa-calendar"></i>&nbsp;&nbsp;{{time_convert($note['create_time'])}}&nbsp;&nbsp;&nbsp;&nbsp;<i
                                        class="fa fa-folder"></i>&nbsp;&nbsp;{{$note['type']}}</span>
                    <span> <i class="fa fa-eye"></i>&nbsp;{{$note['hits']}}&nbsp;&nbsp;<a target="_blank"
                                                                                          style="margin-left: .5em;color: #309bee"
                                                                                          href="/note/{{$note['id']}}.html"><i
                                    class="fa fa-book"></i>&nbsp;&nbsp;继续阅读</a></span>
                </div>
            </div>
        </div>
    @endforeach
</div>
