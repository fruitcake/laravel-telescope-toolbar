<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'dumps', 'link' => route('telescope') . '/dumps', 'status' => 'yellow'])

    @slot('icon')
        @ttIcon('dumps')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot

    @slot("text")

        @foreach ($entries->take(5) as $entry)
            <div class="sf-toolbar-info-piece">
                <div class="sf-toolbar-dump" style="width: 480px;">
                    {!! $entry->content['dump']  !!}
                </div>

            </div>

            @if ($entries->count() > 5)
                <div class="sf-toolbar-info-piece">
                    <span>Showing 5 of {{ $entries->count() }} entries..</span>
                </div>
            @endif
        @endforeach

    @endslot

@endcomponent