<!-- Start of Telescope Toolbar widget !-->
<div id="sfwdt{{ $token }}" class="sf-toolbar sf-display-none" role="region" aria-label="Laravel Telescope Toolbar"></div>

<script @if(isset($csp_script_nonce) && $csp_script_nonce) nonce="{{ $csp_script_nonce }}" @endif>/*<![CDATA[*/
  (function () {
    Sfjs.loadToolbar('{{ $token }}');
  })();
/*]]>*/</script>
<!-- End of Telescope Toolbar widget !-->
