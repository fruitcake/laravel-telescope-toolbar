<div class="sf-toolbar-block sf-toolbar-block-request sf-toolbar-status-normal ">
    <a href="#">
        <div class="sf-toolbar-icon">
            <span class="sf-toolbar-status sf-toolbar-status-green">200</span>
            <span class="sf-toolbar-label"> @</span>
            <span class="sf-toolbar-value sf-toolbar-info-piece-additional">{url}</span>
        </div>
    </a>
    <div class="sf-toolbar-info">
        <div class="sf-toolbar-info-group">
            <div class="sf-toolbar-info-piece">
                <b>HTTP status</b>
                <span>200 OK</span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Controller</b>
                <span>
                    <a href="#" title="..">SomeController :: someAction</a>
                </span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Route name</b>
                <span>{route name}</span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Has session</b>
                <span>yes</span>
            </div>
        </div>
    </div>

    @include('telescope-toolbar::item', ['name' => 'request'])
</div>