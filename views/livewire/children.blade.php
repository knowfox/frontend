<section class="uk-width-1-1">
    @if ($children->count())
        <h2>Children</h2>
        <ul>
            @foreach ($children as $child)
                <li><a href="/{{ $child->id }}">{{ $child->title }}</a></li>
            @endforeach
        </ul>
        {{ $children->links() }}
    @endif
</section>
