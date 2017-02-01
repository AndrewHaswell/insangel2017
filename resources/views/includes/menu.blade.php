<div id="navigation">
        @foreach ($navigation as $link => $title)
            @if (is_string($link))
                <div class="menu-item"><a href="{{url($link)}}">{{$title}}</a></div>
            @endif
        @endforeach
</div>