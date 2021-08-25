
<!-- Start of Telescope Toolbar assets !-->
<script src="{{ route('telescope-toolbar.baseJs') }}?{{ $assetVersion }}"></script>
@if ($lightMode !== 'auto')
    <link href="{{ route('telescope-toolbar.styling') }}?{{ $assetVersion }}&lightMode={{ $lightMode }}" rel="stylesheet">
@else
    <link href="{{ route('telescope-toolbar.styling') }}?{{ $assetVersion }}&lightMode=1" rel="stylesheet">
    <link href="{{ route('telescope-toolbar.styling') }}?{{ $assetVersion }}&lightMode=0" media="(prefers-color-scheme: dark)" rel="stylesheet">
@endif
<script @if(isset($csp_script_nonce) && $csp_script_nonce) nonce="{{ $csp_script_nonce }}" @endif>/*<![CDATA[*/
    (function () {
        @foreach ($requestStack as $request)
        Sfjs.requestStack.push(@json($request));
        @endforeach
    })();
    /*]]>*/</script>
<!-- End of Telescope Toolbar assets !-->
