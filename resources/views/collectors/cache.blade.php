<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */

$calls = 0;
$types = [];

foreach ($entries as $entry) {
    $calls++;

    if (!isset($types[$entry->content['type']])) {
        $types[$entry->content['type']] = 0;
    }
    $types[$entry->content['type']]++;
}

?>
@component('telescope-toolbar::item', ['name' => 'queries', 'link' => true])

    @slot('icon')
        @ttIcon('cache')

        <span class="sf-toolbar-value">{{ $calls }}</span>

        @if (isset($types['missed']))
            <span class="sf-toolbar-info-piece-additional-detail">
                <span class="sf-toolbar-label">(</span><span class="sf-toolbar-value">{{ $types['missed'] }}</span> <span class="sf-toolbar-label">miss)</span>
            </span>
        @endif
    @endslot

    @slot('text')

        @foreach ($types as $type => $count)
            <div class="sf-toolbar-info-piece">
                <b>Cache {{ $type }}</b>
                <span class="sf-toolbar-status ">{{ $count }}</span>
            </div>
        @endforeach

    @endslot

@endcomponent