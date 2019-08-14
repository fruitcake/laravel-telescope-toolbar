<?php
/** @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries */
$data = $entries->first()->content;

$memory = $data['memory'] ?? null;
if (!$memory) {
    return;
}

$statusColor = null;
if ($memory > 50) {
    $statusColor = 'yellow';
} elseif ($memory > 10) {
    $memory = round($memory);
}
?>

@component('telescope-toolbar::item', ['name' => 'memory', 'link' => true])

    @slot('icon')

        @ttIcon('memory')

        <span class="sf-toolbar-value">{{ $memory }}</span>
        <span class="sf-toolbar-label">MB</span>
    @endslot

    @slot('text')

        <div class="sf-toolbar-info-piece">
            <b>Peak memory usage</b>
            <span>{{ $data['memory'] }} MB</span>
        </div>

    @endslot


@endcomponent