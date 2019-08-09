<?php
/** @var \Laravel\Telescope\EntryResult $entry */

$statusCode = $entry->content['response_status'];
if ($statusCode > 400) {
    $statusColor = 'red';
} elseif ($statusCode > 300) {
    $statusColor = 'yellow';
} else {
    $statusColor = 'green';
}
?>

@component('telescope-toolbar::item', ['name' => 'request', 'link' => true])

    @slot('icon')
        <div class="sf-toolbar-icon">
            <span class="sf-toolbar-status sf-toolbar-status-{{ $statusColor }}">{{ $statusCode }}</span>
            <span class="sf-toolbar-label"> @</span>
            <span class="sf-toolbar-value sf-toolbar-info-piece-additional">{{ $entry->content['method'] }} {{ $entry->content['uri'] }}</span>
        </div>
    @endslot

    @slot('text')
        <div class="sf-toolbar-info-group">
            <div class="sf-toolbar-info-piece">
                <b>HTTP status</b>
                <span>{{ $statusCode }}</span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Request URI</b>
                <span title="{{ $entry->content['uri'] }}">{{ $entry->content['method'] }} {{ $entry->content['uri'] }}</span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Controller</b>
                <span>
                    {{ $entry->content['controller_action'] }}
                </span>
            </div>
        </div>
    @endslot

@endcomponent