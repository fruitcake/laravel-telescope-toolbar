<?php
/** @var array|\Illuminate\Support\Collection $entries */
?>

<!-- START of Laravel Telescope Toolbar -->
<div id="sfMiniToolbar-{{ $token }}" class="sf-minitoolbar" data-no-turbolink data-turbo="false">
    <button type="button" title="Show Telescope toolbar" tabindex="-1" id="sfToolbarMiniToggler-{{ $token }}" accesskey="D" aria-expanded="false" aria-controls="sfToolbarMainContent-{{ $token }}">
        @ttIcon('laravel')
    </button>
</div>
<div id="sfToolbarClearer-{{ $token }}" class="sf-toolbar-clearer"></div>

<div id="sfToolbarMainContent-{{ $token }}" class="sf-toolbarreset notranslate clear-fix" data-no-turbolink>

    @foreach (config('telescope-toolbar.collectors') as $type => $templates)
        @if(isset($entries[$type]))
            @foreach($templates as $template)
                @include($template, ['entries' => $entries[$type]])
            @endforeach
        @endif
    @endforeach

    @include("telescope-toolbar::collectors.config")
    @include("telescope-toolbar::collectors.ajax")

    <button class="hide-button" type="button" id="sfToolbarHideButton-{{ $token }}" title="Close Toolbar" tabindex="-1" accesskey="D" aria-expanded="true" aria-controls="sfToolbarMainContent-{{ $token }}">
        @ttIcon('close')
    </button>
</div>
<!-- END of Laravel Telescope Toolbar -->
