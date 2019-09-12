<?php
/** @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries */
$data = $entries->first()->content;

?>

@component('telescope-toolbar::item', ['name' => 'time', 'link' => true])

    @slot('icon')

        @ttIcon('time')

        <span class="sf-toolbar-value">{{ $data['duration'] }}</span>
        <span class="sf-toolbar-label">ms</span>
    @endslot

    @slot('text')

        <div class="sf-toolbar-info-piece">
            <b>Request Duration</b>
            <span>{{ $data['duration'] }} ms</span>
        </div>

        <div class="sf-toolbar-info-piece">
            <b>Peak memory usage</b>
            <span>{{ $data['memory'] }} MB</span>
        </div>

    @endslot

@endcomponent