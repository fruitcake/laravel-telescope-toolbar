<?php
/** @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries */
$data = $entries->first()->content['user'] ?? [];

?>

@component('telescope-toolbar::item', ['name' => 'user', 'link' => true])

    @slot('icon')

        @ttIcon('user')

        <span class="sf-toolbar-value">{{ $data['email'] ?? 'n/a' }}</span>
    @endslot

    @slot('text')
        @if($data)
            <div class="sf-toolbar-info-group">
                @foreach ($data as $key => $value)
                    @if (!empty($value))
                        <div class="sf-toolbar-info-piece">
                            <b>{{ $key }}</b>
                            <span>{{ $value }}</span>
                        </div>
                    @endif
               @endforeach
            </div>
        @endif
    @endslot

@endcomponent