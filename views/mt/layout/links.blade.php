@foreach($links as $link)
    <a class="tags friendlink" data-id="{{$link['id']}}" target="_blank" title="{{$link['description']}}"
       href="{{$link['url']}}"
       rel="noopener">{{$link['name']}}</a>
@endforeach
