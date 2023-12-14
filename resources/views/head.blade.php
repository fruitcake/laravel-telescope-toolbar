
<!-- Start of Telescope Toolbar assets !-->
<script src="{{ route('telescope-toolbar.baseJs') }}?{{ $assetVersion }}"></script>
<link href="{{ route('telescope-toolbar.styling') }}?{{ $assetVersion }}&lightMode=0" rel="stylesheet">
@if ($lightMode)
    <link href="{{ route('telescope-toolbar.styling') }}?{{ $assetVersion }}&lightMode=1" @if($lightMode === 'auto') media="(prefers-color-scheme: light)" @endif rel="stylesheet">
@endif

<script @if(isset($csp_script_nonce) && $csp_script_nonce) nonce="{{ $csp_script_nonce }}" @endif>/*<![CDATA[*/
    (function () {
        @foreach ($requestStack as $request)
        Sfjs.requestStack.push(@json($request));
        @endforeach
    })();
    /*]]>*/</script>
<!-- End of Telescope Toolbar assets !-->
