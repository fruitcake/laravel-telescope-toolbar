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
    $queries[$query->familyHash ?: $query->content['sql']] = $query->content['sql'];
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
            <span class="sf-toolbar-value">{{ $query_time }}</span>
            <span class="sf-toolbar-label">ms</span>
        </span>

    @endslot

    @slot('text')

        <div class="sf-toolbar-info-piece">
            <b>Database Queries</b>
            <span class="sf-toolbar-status ">{{ $num_queries  }}</span>
        </div>

        <div class="sf-toolbar-info-piece">
            <b>Slow Queries</b>
            <span class="sf-toolbar-status ">{{ $num_slow }}</span>
        </div>

        <div class="sf-toolbar-info-piece">
            <b>Duplicate Queries</b>
            <span class="sf-toolbar-status ">{{ $num_duplicated }}</span>
        </div>

        <div class="sf-toolbar-info-piece">
            <b>Query time</b>
            <span>{{ $query_time }} ms</span>
        </div>

    @endslot

@endcomponent