<!-- START of Laravel Telescope Toolbar -->
<div id="sfMiniToolbar-{{ $token }}" class="sf-minitoolbar" data-no-turbolink>
    <a href="#" title="Show Telescope toolbar" tabindex="-1" id="sfToolbarMiniToggler-{{ $token }}" accesskey="D">
        @ttIcon('telescope')
    </a>
</div>
<div id="sfToolbarClearer-{{ $token }}" class="sf-toolbar-clearer"></div>

<div id="sfToolbarMainContent-{{ $token }}" class="sf-toolbarreset clear-fix" data-no-turbolink>

    @include("telescope-toolbar::collectors.ajax")

    @if(isset($entries['request']))
        @include("telescope-toolbar::collectors.request", ['entries' => $entries['request']])
        @include("telescope-toolbar::collectors.user", ['entries' => $entries['request']])
        @include("telescope-toolbar::collectors.time", ['entries' => $entries['request']])
    @endif

    @if(isset($entries['query']))
        @include("telescope-toolbar::collectors.queries", ['entries' => $entries['query']])
    @endif

    @if(isset($entries['cache']))
        @include("telescope-toolbar::collectors.cache", ['entries' => $entries['cache']])
    @endif


    @include("telescope-toolbar::collectors.config")

    <a class="hide-button" id="sfToolbarHideButton-{{ $token }}" title="Close Toolbar" tabindex="-1" accesskey="D">
        @ttIcon('telescope')
    </a>
</div>
<!-- END of Laravel Telescope Toolbar -->