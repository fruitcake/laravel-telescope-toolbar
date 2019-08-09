@component('telescope-toolbar::item', ['name' => 'ajax'])

    @slot('icon')
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="#AAA" d="M9.8 18L6 22.4c-.3.3-.8.4-1.1 0L1 18c-.4-.5-.1-1 .5-1H3V6.4C3 3.8 5.5 2 8.2 2h3.9c1.1 0 2 .9 2 2s-.9 2-2 2H8.2C7.7 6 7 6 7 6.4V17h2.2c.6 0 1 .5.6 1zM23 6l-3.8-4.5a.8.8 0 0 0-1.1 0L14.2 6c-.4.5-.1 1 .5 1H17v10.6c0 .4-.7.4-1.2.4h-3.9c-1.1 0-2 .9-2 2s.9 2 2 2h3.9c2.6 0 5.2-1.8 5.2-4.4V7h1.5c.6 0 .9-.5.5-1z"/>
        </svg>

        <span class="sf-toolbar-value sf-toolbar-ajax-request-counter">0</span>

    @endslot

    @slot("text")
        <div class="sf-toolbar-info-piece">
                <span class="sf-toolbar-header">
                    <b class="sf-toolbar-ajax-info"></b>
                    <b class="sf-toolbar-action">(<a class="sf-toolbar-ajax-clear" href="javascript:void(0);">Clear</a>)</b>
                </span>
        </div>
        <div class="sf-toolbar-info-piece">
            <table class="sf-toolbar-ajax-requests">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Profile</th>
                    <th>Method</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>URL</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody class="sf-toolbar-ajax-request-list"></tbody>
            </table>
        </div>

    @endslot
@endcomponent