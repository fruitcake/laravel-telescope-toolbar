<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'events', 'link' => true])

    @slot('icon')
        @ttIcon('events')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot


@endcomponent