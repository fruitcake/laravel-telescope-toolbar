<div id="sfwdt{{ $token }}" class="sf-toolbar sf-display-none"></div>

@include("telescope-toolbar::base_js")

@include("telescope-toolbar::styling")

<script @if(isset($csp_script_nonce) && $csp_script_nonce) nonce="{{ $csp_script_nonce }}" @endif>/*<![CDATA[*/
  (function () {
    Sfjs.loadToolbar('{{ $token }}');
  })();
/*]]>*/</script>
