<!-- START of Laravel Telescope Toolbar -->
<div id="sfMiniToolbar-{{ $token }}" class="sf-minitoolbar" data-no-turbolink>
    <a href="#" title="Show Telescope toolbar" tabindex="-1" id="sfToolbarMiniToggler-{{ $token }}" accesskey="D">
        @ttIcon('telescope')
    </a>
</div>
<div id="sfToolbarClearer-{{ $token }}" class="sf-toolbar-clearer"></div>

<div id="sfToolbarMainContent-{{ $token }}" class="sf-toolbarreset clear-fix" data-no-turbolink>

    @if($request)
        @include("telescope-toolbar::collectors.request", ['data' => $request, 'redirect' => $redirect])
        @include("telescope-toolbar::collectors.user", ['data' => $request['user'] ?? []])
        @include("telescope-toolbar::collectors.time", ['data' => $request ?? []])
    @endif



    @if($database)
        @include("telescope-toolbar::collectors.database", ['data' => $database])
    @endif

    @include("telescope-toolbar::collectors.ajax")
    @include("telescope-toolbar::collectors.config")

    <a class="hide-button" id="sfToolbarHideButton-{{ $token }}" title="Close Toolbar" tabindex="-1" accesskey="D">
        @ttIcon('telescope')
    </a>
</div>
<!-- END of Laravel Telescope Toolbar -->