<?php
/** @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries */
$data = $entries->first()->content;

$statusCode = $data['response_status'];
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
        <span class="sf-toolbar-status sf-toolbar-status-{{ $statusColor }}">{{ $statusCode }}</span>
        <span class="sf-toolbar-value sf-toolbar-info-piece-additional">{{ $data['method'] }} {{ $data['uri'] }}</span>
    @endslot

    @slot('text')
        <div class="sf-toolbar-info-group">
            <div class="sf-toolbar-info-piece">
                <b>HTTP status</b>
                <span>{{ $statusCode }}</span>
            </div>

            @if($data['method'] !== 'GET')
            <div class="sf-toolbar-info-piece">
                <b>Method</b>
                <span>{{ $data['method'] }}</span>
            </div>
            @endif

            <div class="sf-toolbar-info-piece">
                <b>Request URI</b>
                <span title="{{ $data['uri'] }}">{{ $data['method'] }} {{ $data['uri'] }}</span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Controller Action</b>
                <span>
                    {{ $data['controller_action'] }}
                </span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Middleware</b>
                <span>
                    {{ implode(', ', array_filter($data['middleware'])) ?: '-' }}
                </span>
            </div>

            @if(isset($data['response']['view']))
                <div class="sf-toolbar-info-piece">
                    <b>View</b>
                    <span>
                       {{ str_replace(base_path(), '', $data['response']['view']) }}
                    </span>
                </div>
            @elseif(isset($data['response']) && is_string($data['response']))
                <div class="sf-toolbar-info-piece">
                    <b>Response</b>
                    <span>
                       {{ \Illuminate\Support\Str::limit($data['response'], 60) }}
                    </span>
                </div>
            @endif

        </div>
    @endslot

@endcomponent
