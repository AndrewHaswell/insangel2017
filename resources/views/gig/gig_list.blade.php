<pre>
@if (!empty($gigs))
        @foreach ($gigs as $gig)
            {{date('l jS F', strtotime($gig['datetime']))}}
            @if (!empty($gig['title']))
                {{$gig['title']}}
            @endif
        @endforeach

    @endif
</pre>
