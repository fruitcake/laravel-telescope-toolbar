<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'notifications', 'link' => true])

    @slot('icon')
        @ttIcon('notifications')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot

    @slot('text')

        <div class="sf-toolbar-info-piece">
            <table class="sf-toolbar-previews">
                <thead>
                <tr>
                    <th>Details</th>
                    <th>Channel</th>
                    <th>Message</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($entries->take(5) as $entry)
                    <tr>
                        <td>
                            <a href="{{ route('telescope') }}/notifications/{{ $entry->id }}" target="_telescope">
                                view
                            </a>
                        </td>

                        <td title="{{ $entry->content['channel'] }}">
                            {{ \Illuminate\Support\Str::limit($entry->content['channel'] ?: '-', 20) }}
                            @if($entry->content['queued'])
                                <br><small>queued</small>
                            @else
                                <br><small>sync</small>
                            @endif
                        </td>

                        <td title="{{ $entry->content['notification'] }}">
                            {{ \Illuminate\Support\Str::limit($entry->content['notification'] ?: '-', 70) }}<br>
                            <small>
                                Recipient:  {{ \Illuminate\Support\Str::limit($entry->content['notifiable'], 90) }}
                            </small>
                        </td>

                    </tr>
                @endforeach
                @if ($entries->count() > 5)
                    <tfoot>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><small>Showing 5 of {{ $entries->count() }} entries..</small></td>
                    </tr>
                    </tfoot>
                @endif
                </tbody>

            </table>
        </div>

    @endslot

@endcomponent