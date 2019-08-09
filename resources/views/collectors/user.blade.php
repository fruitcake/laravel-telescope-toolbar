@component('telescope-toolbar::item', ['name' => 'user', 'link' => true])

    @slot('icon')

        @ttIcon('user')

        <span class="sf-toolbar-value">{{ $data['email'] ?? 'n/a' }}</span>
    @endslot

    @slot('text')
        <div class="sf-toolbar-info-group">
            @foreach ($data as $key => $value)
                <div class="sf-toolbar-info-piece">
                    <b>{{ $key }}</b>
                    <span>{{ $value }}</span>
                </div>
           @endforeach
        </div>
    @endslot

@endcomponent