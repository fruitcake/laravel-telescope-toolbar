<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'jobs', 'link' => true])

    @slot('icon')
        @ttIcon('jobs')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot


@endcomponent