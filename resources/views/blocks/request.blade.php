<?php
/** @var \Laravel\Telescope\EntryResult $entry */
?>
<div class="sf-toolbar-block sf-toolbar-block-request sf-toolbar-status-normal">
    <a href="{{ route('telescope') }}/requests/{{ $entry->id }}">
        <div class="sf-toolbar-icon">
            <span class="sf-toolbar-status sf-toolbar-status-green">{{ $entry->content['response_status'] }}</span>
            <span class="sf-toolbar-label"> @</span>
            <span class="sf-toolbar-value sf-toolbar-info-piece-additional">{{ $entry->content['method'] }} {{ $entry->content['uri'] }}</span>
        </div>
    </a>
    <div class="sf-toolbar-info">
        <div class="sf-toolbar-info-group">
            <div class="sf-toolbar-info-piece">
                <b>HTTP status</b>
                <span>{{ $entry->content['response_status'] }}</span>
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
    </div>

</div>