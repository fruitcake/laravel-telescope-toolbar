<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'gates', 'link' => true])

    @slot('icon')
        @ttIcon('gates')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot


    @slot('text')

        <table class="sf-toolbar-previews">
            <thead>
            <tr>
                <th>Ability</th>
                <th>Result</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($entries as $entry)
                <tr>
                    <td title="{{ $entry->content['ability'] }}">
                        {{ \Illuminate\Support\Str::limit($entry->content['ability'], 60) }}
                    </td>
                    <td>
                        {{ $entry->content['result'] }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endslot

@endcomponent