<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */


?>
@component('telescope-toolbar::item', ['name' => 'models', 'link' => true])

    @slot('icon')
        @ttIcon('models')

        <span class="sf-toolbar-value">{{ $entries->count() }}</span>

    @endslot

    @slot('text')

        <div class="sf-toolbar-info-piece">
            <table class="sf-toolbar-previews">

                <thead>
                <tr>
                    <th>Action</th>
                    <th>Model</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($entries as $entry)
                    <tr>
                        <td>
                            {{ $entry->content['action'] }}
                        </td>

                        <td>
                            <a href="{{ route('telescope') }}/models/{{ $entry->id }}" target="_telescope">
                                {{ $entry->content['model'] }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

    @endslot

@endcomponent