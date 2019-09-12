<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'dump', 'link' => route('telescope') . '/dumps', 'status' => 'yellow'])

    @slot('icon')
        @ttIcon('dumps')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot

    @slot("text")

        @foreach ($entries as $entry)
            <div class="sf-toolbar-info-piece">
                <div class="sf-toolbar-dump">
                    {!! $entry->content['dump']  !!}
                </div>

            </div>

        @endforeach

    @endslot

@endcomponent