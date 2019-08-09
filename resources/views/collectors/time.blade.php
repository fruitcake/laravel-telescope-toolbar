@component('telescope-toolbar::item', ['name' => 'user', 'link' => true])

    @slot('icon')

        @ttIcon('time')

        <span class="sf-toolbar-value">{{ $data['duration'] }}</span>
        <span class="sf-toolbar-label">ms</span>
    @endslot

@endcomponent