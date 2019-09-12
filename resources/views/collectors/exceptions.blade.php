<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'exceptions', 'link' => true, 'status' => 'red'])

    @slot('icon')
        @ttIcon('exceptions')

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
                    @foreach ($entries as $entry)
                        <tr>
                            <td>
                                <a href="{{ route('telescope') }}/exceptions/{{ $entry->id }}" target="_telescope">
                                    view
                                </a>
                            </td>

                            <td title="{{ $entry->content['class'] }}">
                                {{ \Illuminate\Support\Str::limit($entry->content['class'], 70) }}<br>
                                <small>{{ \Illuminate\Support\Str::limit($entry->content['message'], 100) }}</small>
                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endslot

@endcomponent