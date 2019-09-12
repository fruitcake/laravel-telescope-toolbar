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

           <table class="sf-toolbar-previews">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Action</th>
                </tr>
            </thead>
                <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            <td title="{{ $entry->content['key'] }}">
                                {{ \Illuminate\Support\Str::limit($entry->content['key'], 60) }}
                            </td>
                            <td>
                                {{ $entry->content['type'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
        </table>

    @endslot

@endcomponent