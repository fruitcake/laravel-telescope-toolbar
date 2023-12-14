<div class="sf-toolbar-block sf-toolbar-block-{{ $name }} sf-toolbar-status-{{ $status ?? 'normal' }} {{ $additional_classes ?? ''}}" {!! $block_attrs ?? '' !!}>
    @if(isset($link) && $link)
        @php
            $ttLink = route('telescope-toolbar.show', ['token' => $token, 'tab' => $name]);
            if ($link === true) {
                $link = $ttLink;
            } elseif (\Illuminate\Support\Str::startsWith($link, '#')) {
                $link = $ttLink . $link;
            }
        @endphp
        <a href="{{ $link }}">
    @endif
        <div class="sf-toolbar-icon">{{ $icon ?? '' }}</div>
        @if(isset($link) && $link)</a>@endif
    <div class="sf-toolbar-info">{{ $text ?? '' }}</div>
</div>
