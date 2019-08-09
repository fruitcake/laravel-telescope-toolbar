<?php
/** @var \Laravel\Telescope\EntryResult $entry */

$statusCode = $request['response_status'];
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
        <span class="sf-toolbar-label"> @</span>
        <span class="sf-toolbar-value sf-toolbar-info-piece-additional">{{ $request['method'] }} {{ $request['uri'] }}</span>
    @endslot

    @slot('text')
        <div class="sf-toolbar-info-group">
            <div class="sf-toolbar-info-piece">
                <b>HTTP status</b>
                <span>{{ $statusCode }}</span>
            </div>

            @if($request['method'] !== 'GET')
            <div class="sf-toolbar-info-piece">
                <b>Method</b>
                <span>{{ $request['method'] }}</span>
            </div>
            @endif

            <div class="sf-toolbar-info-piece">
                <b>Request URI</b>
                <span title="{{ $request['uri'] }}">{{ $request['method'] }} {{ $request['uri'] }}</span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Controller Action</b>
                <span>
                    {{ $request['controller_action'] }}
                </span>
            </div>

            @if(isset($redirect_handler))
            <div class="sf-toolbar-info-group">
                <div class="sf-toolbar-info-piece">
                    <b>
                        <span class="sf-toolbar-redirection-status sf-toolbar-status-yellow">{{ $redirect_status_code }}</span>
                        Redirect from
                    </b>
                    <span>
                        {{ $redirect_handler }}
                        (<a href="{{ route('telescope-toolbar.show', ['token' => $redirect_token, 'panel' => $name]) }}" target="_telescope">{{ $redirect_token }}</a>)
                    </span>
                </div>
            </div>
            @endif
        </div>
    @endslot

@endcomponent