<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'redis', 'link' => true])

    @slot('icon')
        @ttIcon('redis')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot


@endcomponent