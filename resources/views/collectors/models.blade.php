<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'models', 'link' => true])

    @slot('icon')
        @ttIcon('models')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot


@endcomponent