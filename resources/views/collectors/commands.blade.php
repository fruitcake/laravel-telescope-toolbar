<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'commands', 'link' => true])

    @slot('icon')
        @ttIcon('commands')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot


@endcomponent