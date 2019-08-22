<div class="sf-toolbar-block sf-toolbar-block-{{ $name }} sf-toolbar-status-{{ $status ?? 'normal' }} {{ $additional_classes ?? ''}}" {!! $block_attrs ?? '' !!}>
    @if(isset($link) && $link) <a href="{{  is_string($link) ? $link : route('telescope-toolbar.show', ['token' => $token, 'tab' => $name]) }}"  target="_telescope">@endif
        <div class="sf-toolbar-icon">{{ $icon ?? '' }}</div>
        @if(isset($link) && $link)</a>@endif
    <div class="sf-toolbar-info">{{ $text ?? '' }}</div>
</div>