<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'dumps', 'link' => true])

    @slot('icon')
        @ttIcon('dumps')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot


@endcomponent