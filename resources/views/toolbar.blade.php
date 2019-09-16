<?php
/** @var array|\Illuminate\Support\Collection $entries */
?>

<!-- START of Laravel Telescope Toolbar -->
<div id="sfMiniToolbar-{{ $token }}" class="sf-minitoolbar" data-no-turbolink>
    <a class="open-button" href="#" title="Show Telescope toolbar" tabindex="-1" id="sfToolbarMiniToggler-{{ $token }}" accesskey="D">
        @ttIcon('telescope')
    </a>
</div>
<div id="sfToolbarClearer-{{ $token }}" class="sf-toolbar-clearer"></div>

<div id="sfToolbarMainContent-{{ $token }}" class="sf-toolbarreset clear-fix" data-no-turbolink>

    @include("telescope-toolbar::collectors.ajax")

    @foreach (config('telescope-toolbar.collectors') as $type => $templates)
        @if(isset($entries[$type]))
            @foreach($templates as $template)
                @include($template, ['entries' => $entries[$type]])
            @endforeach
        @endif
    @endforeach

    @include("telescope-toolbar::collectors.config")

    <a class="hide-button" id="sfToolbarHideButton-{{ $token }}" title="Close Toolbar" tabindex="-1" accesskey="D">
        @ttIcon('telescope')
    </a>
</div>
<!-- END of Laravel Telescope Toolbar -->