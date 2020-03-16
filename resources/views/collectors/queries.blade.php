<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */

$num_queries = 0;
$num_slow = 0;
$query_time = 0;
$queries = [];
foreach ($entries as $query) {
    $num_queries++;
    if ($query->content['slow'] ?? false) {
        $num_slow++;
    }
    $query_time += (float) str_replace(',', '', $query->content['time']) ?? 0;
    $queries[$query->content['hash'] ?? $query->content['sql']] = $query->content['sql'];
}

$num_duplicated = $num_queries - count($queries);
if ($num_queries > 0 && $num_duplicated > $num_queries *.75) {
    $statusColor = 'yellow';
} else {
    $statusColor = null;
}
?>
@component('telescope-toolbar::item', ['name' => 'queries', 'link' => true, 'status' => $statusColor, 'additional_classes' => 'sf-toolbar-block-fullwidth'])

    @slot('icon')
        @ttIcon('queries')

        <span class="sf-toolbar-value">{{ $num_queries }}</span>

        <span class="sf-toolbar-info-piece-additional-detail">
            <span class="sf-toolbar-label">in</span>
            <span class="sf-toolbar-value">{{ round($query_time) }}</span>
            <span class="sf-toolbar-label">ms</span>
        </span>

    @endslot

    @slot('text')

        <table class="sf-toolbar-previews">
            <thead>
            <tr>
                <th>Query<br/><small>{{ $num_queries }} queries, {{ $num_duplicated }} of which are duplicated and {{ $num_slow }} slow.</small></th>
                <th style="width: 30px">Duration<br/><small>{{ number_format($query_time, 2) }} ms</small></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($entries as $query)
                @php($path = str_replace(base_path(), '', $query->content['file']))
                <tr>
                    <td class="monospace sf-query">
                        {{ $query->content['sql'] }}
                    </td>

                    <td title="{{ $path }}:{{ $query->content['line'] }}">
                        {{ number_format((float) str_replace(',', '', $query->content['time']), 2) }}ms<br/>
                        <small>{{ strlen($path) > 32 ? '..' . substr($path, -30) : $path }}:{{ $query->content['line'] }}</small>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    @endslot

@endcomponent
