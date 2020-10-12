@extends('frontend::uikit3.layouts.app')

@section('content')
    <div class="uk-container uk-padding uk-height-viewport uk-background-default">

        <div class="uk-flex uk-flex-between">
            @include('crud::' . $theme . '.partials.breadcrumbs', [
                'breadcrumbs' => ['/toplevel' => '<img src="/img/knowfox-icon.png">'] 
                    + $concept->ancestors->mapWithKeys(function ($c) {
                    return [ "/{$c->id}" => $c->title ];
                })->toArray()
                    + [ "/{$concept->id}" => $concept->title ]
            ])
            <div class="uk-margin-top uk-flex-none">
                <div class="uk-button-group">
                    <button type="button" uk-icon="pencil"></button>
                    <div class="uk-inline">
                        <button type="button" uk-icon="triangle-down">
                        <div uk-dropdown="mode: click; boundary: ! .uk-button-group; boundary-align: true;">
                            <ul>
                                <li class="uk-active"><a href="">Add child</a></li>
                                <li><a href="">Share</a></li>
                                <li><a href="">Attachments</a></li>
                                <li><a href="">Slides</a></li>
                                <li><a href="">Versions</a></li>
                                <li><a href="">Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('crud::' . $theme . '.partials.messages')

        <h1>{!! $page_title !!}</h1>

        <p class="uk-text-meta">Concept <a href="/{{ $concept->id }}">{{ $concept->id }}</a>, 
            created at {{ $concept->created_at }}, 
            viewed {{ $concept->viewed_count }} times.</p>

        @if ($concept->summary)
            <p class="uk-text-bold">{{ $concept->summary }}</p>
        @endif

        <div class="uk-grid-divider display" uk-grid>
            <section class="uk-width-2-3">
                {!! $concept->rendered_body !!}
            </section>

            @if ($concept->related && $concept->related->count() || $concept->inverse_related && $concept->inverse_related->count())
                <section class="uk-width-1-3">
                    <h2>Related</h2>
                    @if ($concept->related && $concept->related->count())
                        <ul>
                            @foreach ($concept->related as $related)
                                <li>{{ $related->pivot->type }} 
                                    <a class="uk-margin-small-left" href="/{{ $related->id }}">{{ $related->title }}</a></li>
                            @endforeach 
                        </ul>
                    @endif
                    @if ($concept->inverse_related && $concept->inverse_related->count())
                        <ul>
                            @foreach ($concept->inverse_related as $related)
                                <li>{{ $related->pivot->type }} 
                                    <a class="uk-margin-small-left" href="/{{ $related->id }}">{{ $related->title }}</a></li>
                            @endforeach 
                        </ul>
                    @endif
                </section>
            @endif

            @livewire('children', [ 'concept' => $concept ])
        </div>
    </div>
@endsection