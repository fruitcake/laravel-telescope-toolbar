<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */

$info = 0;
$warnings = 0;
$errors = 0;
$total = 0;

$levels = [];
foreach ($entries as $entry) {
    $level = $entry->content['level'];

    if (in_array($level, ['debug', 'info'])) {
        $info++;
    } elseif (in_array($level, ['notice', 'warning'])) {
        $warnings++;
    } else {
        $errors++;
    }

    if (!isset($levels[$entry->content['level']])) {
        $levels[$entry->content['level']] = 0;
    }
    $levels[$entry->content['level']]++;

    $total++;
}

if ($errors) {
    $statusColor = 'red';
} elseif ($warnings) {
    $statusColor = 'yellow';
} else {
    $statusColor = null;
}

?>
@component('telescope-toolbar::item', ['name' => 'logs ', 'link' => true, 'status' => $statusColor])

    @slot('icon')
        @ttIcon('logs')

        <span class="sf-toolbar-value">{{ $total }}</span>

    @endslot

    @slot('text')

        @foreach ($levels as $level => $count)
            <div class="sf-toolbar-info-piece">
                <b>{{ $level }}</b>
                <span class="sf-toolbar-status ">{{ $count }}</span>
            </div>
        @endforeach

    @endslot

@endcomponent