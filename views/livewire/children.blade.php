<section class="uk-width-1-1">
    @if ($children->count())
        <h2>Children</h2>

        @if ($concept->type == 'folder')
            <table>
                @include('frontend::uikit3.partials.table-header')
                @foreach ($children as $child)
                    @include('frontend::uikit3.partials.table-row', [ 'concept' => $child ])
                @endforeach
            </table>
        @else
            <ul>
                @foreach ($children as $child)
                    <li><a href="/{{ $child->id }}">{{ $child->title }}</a></li>
                @endforeach
            </ul>
        @endif        
        {{ $children->links() }}
    @endif
</section>
