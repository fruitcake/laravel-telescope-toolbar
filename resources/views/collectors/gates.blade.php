<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'gates', 'link' => true])

    @slot('icon')
        @ttIcon('gates')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot



@endcomponent