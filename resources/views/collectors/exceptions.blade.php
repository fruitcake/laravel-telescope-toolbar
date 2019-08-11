<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'exceptions', 'link' => true, 'status' => 'red'])

    @slot('icon')
        @ttIcon('exceptions')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot


@endcomponent