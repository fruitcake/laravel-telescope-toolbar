<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'notifications', 'link' => true])

    @slot('icon')
        @ttIcon('notifications')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot

    @slot('text')

       

    @endslot

@endcomponent