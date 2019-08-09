@component('telescope-toolbar::item', ['name' => 'security', 'link' => true])

    @slot('icon')
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#AAA" d="M21 20.4V22H3v-1.6c0-3.7 2.4-6.9 5.8-8-1.7-1.1-2.9-3-2.9-5.2 0-3.4 2.7-6.1 6.1-6.1s6.1 2.7 6.1 6.1c0 2.2-1.2 4.1-2.9 5.2 3.4 1.1 5.8 4.3 5.8 8z"/></svg>

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