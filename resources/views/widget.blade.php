<div id="sfwdt{{ $token }}" class="sf-toolbar sf-display-none"></div>

@include("telescope-toolbar::base_js")

@include("telescope-toolbar::styling")

<script @if(isset($csp_script_nonce) && $csp_script_nonce) nonce="{{ $csp_script_nonce }}" @endif>/*<![CDATA[*/
  (function () {
    Sfjs.loadToolbar('{{ $token }}');
    Sfjs.requestStack.push({
      error: false,
      duration: {{ $duration ?? 1 }},
      statusCode: {{ $statusCode ?? 200 }},
      url: '{{ \Illuminate\Support\Facades\Request::url() }}',
      method: '{{ \Illuminate\Support\Facades\Request::method() }}',
      type: 'doc',
      start: new Date(),
      profile: '{{ $token }}',
      profilerUrl: '{{ route('telescope-toolbar.show', ['token' => $token])  }}'
    })
  })();
/*]]>*/</script>
