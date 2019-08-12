<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'jobs', 'link' => true])

    @slot('icon')
        @ttIcon('jobs')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot

    @slot('text')

        <div class="sf-toolbar-info-piece">
            <table class="sf-toolbar-previews">
                <thead>
                <tr>
                    <th>Details</th>
                    <th>Message</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($entries->take(5) as $entry)
                    <tr>
                        <td>
                            <a href="{{ route('telescope') }}/exceptions/{{ $entry->id }}" target="_telescope">
                                view
                            </a>
                        </td>

                        <td title="{{ $entry->content['name'] }}">
                            {{ \Illuminate\Support\Str::limit($entry->content['name'], 70) }}<br>
                            <small>
                                Connection: {{ $entry->content['connection'] }} | Queue: {{ $entry->content['queue'] }}
                            </small>
                        </td>
                    </tr>
                @endforeach
                @if ($entries->count() > 5)
                    <tfoot>
                        <tr>
                            <td>&nbsp;</td>
                            <td><small>Showing 5 of {{ $entries->count() }} entries..</small></td>
                        </tr>
                    </tfoot>
                    @endif
                </tbody>

            </table>
        </div>
    @endslot
@endcomponent