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

        <div class="sf-toolbar-info-piece">
            <table class="sf-toolbar-previews">
                <thead>
                <tr>
                    <th>Details</th>
                    <th>Level</th>
                    <th>Message</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($entries as $entry)
                    <tr >
                        <td>
                            <a href="{{ route('telescope') }}/logs/{{ $entry->id }}" target="_telescope">
                                view
                            </a>
                        </td>

                        <td>
                            {{ $entry->content['level'] }}
                        </td>

                        <td title="{{ $entry->content['message'] }}">
                            {{ \Illuminate\Support\Str::limit($entry->content['message'], 90) }}
                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    @endslot


@endcomponent