<div id="sfwdt{{ $token }}" class="sf-toolbar sf-display-none"></div>

@include("laravel-telescope::base_js")

@include("laravel-telescope::styling")

<script @if(isset($csp_script_nonce) && $csp_script_nonce) nonce="{{ $csp_script_nonce }}" @endif>/*<![CDATA[*/
  (function () {
    Sfjs.loadToolbar('{{ $token }}');
  })();
  /*]]>*/</script>
