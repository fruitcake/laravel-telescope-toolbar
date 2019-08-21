@component('telescope-toolbar::item', ['name' => 'ajax'])

    @slot('icon')

        @ttIcon('ajax')

        <span class="sf-toolbar-value sf-toolbar-ajax-request-counter">0</span>

    @endslot

    @slot("text")
        <div class="sf-toolbar-info-piece">
                <span class="sf-toolbar-header">
                    <b class="sf-toolbar-ajax-info"></b>
                    <b class="sf-toolbar-action">(<a class="sf-toolbar-ajax-clear" href="javascript:void(0);">Clear</a>)</b>
                    <b class="sf-toolbar-action"><span class="sf-toolbar-ajax-replace-state">Auto</span> (<a class="sf-toolbar-ajax-replace-toggle" href="javascript:void(0);">Toggle</a>)</b>
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