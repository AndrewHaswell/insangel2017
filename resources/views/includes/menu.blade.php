<div class="wrapper">
  <div class="project-container">
    <div id="navigation">
      <ul>
        @foreach ($navigation as $link => $title)
          @if (is_string($link))
            <li>
              <div class="project-box"><a href="{{url($link)}}">{{$title}}</a></div>
            </li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
</div>