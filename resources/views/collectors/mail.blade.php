<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'mail', 'link' => true])

    @slot('icon')
        @ttIcon('mail')

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
                            <a href="{{ route('telescope') }}/mail/{{ $entry->id }}" target="_telescope">
                                view
                            </a>
                        </td>

                        <td title="{{ $entry->content['mailable'] }}">
                            {{ \Illuminate\Support\Str::limit($entry->content['mailable'] ?: '-', 70) }}<br>
                            <small>
                                @if($entry->content['queued'])
                                    Queued |
                                @endif
                                Subject: {{ \Illuminate\Support\Str::limit($entry->content['subject'], 90) }}
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