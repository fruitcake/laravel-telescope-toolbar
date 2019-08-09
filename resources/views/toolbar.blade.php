<!-- START of Laravel Telescope Toolbar -->
<div id="sfMiniToolbar-{{ $token }}" class="sf-minitoolbar" data-no-turbolink>
    <a href="#" title="Show Telescope toolbar" tabindex="-1" id="sfToolbarMiniToggler-{{ $token }}" accesskey="D">
        <svg width="24" height="24"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
            <path fill="#AAA" d="M0 40a39.87 39.87 0 0 1 11.72-28.28A40 40 0 1 1 0 40zm34 10a4 4 0 0 1-4-4v-2a2 2 0 1 0-4 0v2a4 4 0 0 1-4 4h-2a2 2 0 1 0 0 4h2a4 4 0 0 1 4 4v2a2 2 0 1 0 4 0v-2a4 4 0 0 1 4-4h2a2 2 0 1 0 0-4h-2zm24-24a6 6 0 0 1-6-6v-3a3 3 0 0 0-6 0v3a6 6 0 0 1-6 6h-3a3 3 0 0 0 0 6h3a6 6 0 0 1 6 6v3a3 3 0 0 0 6 0v-3a6 6 0 0 1 6-6h3a3 3 0 0 0 0-6h-3zm-4 36a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM21 28a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
        </svg>
</div>
<div id="sfToolbarClearer-{{ $token }}" class="sf-toolbar-clearer"></div>

<div id="sfToolbarMainContent-{{ $token }}" class="sf-toolbarreset clear-fix" data-no-turbolink>

    @if($request)
        @include("telescope-toolbar::collector.request", ['data' => $request, 'redirect' => $redirect])
        @include("telescope-toolbar::collector.security", ['data' => $request['user'] ?? []])
    @endif

        @include("telescope-toolbar::collector.ajax")

    @if($database)
        @include("telescope-toolbar::collector.database", ['data' => $database])
    @endif

    @include("telescope-toolbar::collector.config")

    <a class="hide-button" id="sfToolbarHideButton-{{ $token }}" title="Close Toolbar" tabindex="-1" accesskey="D">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#AAA" d="M21.1 18.3c.8.8.8 2 0 2.8-.4.4-.9.6-1.4.6s-1-.2-1.4-.6L12 14.8l-6.3 6.3c-.4.4-.9.6-1.4.6s-1-.2-1.4-.6a2 2 0 0 1 0-2.8L9.2 12 2.9 5.7a2 2 0 0 1 0-2.8 2 2 0 0 1 2.8 0L12 9.2l6.3-6.3a2 2 0 0 1 2.8 0c.8.8.8 2 0 2.8L14.8 12l6.3 6.3z"/></svg>
    </a>
</div>
<!-- END of Laravel Telescope Toolbar -->