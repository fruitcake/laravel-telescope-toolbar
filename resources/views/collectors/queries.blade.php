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
    $query_time += $query->content['time'] ?? 0;
    $queries[$query->content['hash'] ?? $query->content['sql']] = $query->content['sql'];
}

$num_duplicated = $num_queries - count($queries);
if ($num_queries > 0 && $num_duplicated > $num_queries *.75) {
    $statusColor = 'yellow';
} else {
    $statusColor = null;
}
?>
@component('telescope-toolbar::item', ['name' => 'queries', 'link' => true, 'status' => $statusColor])

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
                <th>Duration<br/><small>{{ number_format($query_time, 2) }} ms</small></th>
            </tr>
            </thead>

            <tbody>
            @foreach ($entries as $query)
                <tr>
                    <td title="{{ $query->content['sql'] }}" class="monospace">
                        {{ \Illuminate\Support\Str::limit($query->content['sql'], 67) }}
                    </td>
                    <td>
                        {{ number_format($query->content['time'], 2) }}ms
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    @endslot

@endcomponent
