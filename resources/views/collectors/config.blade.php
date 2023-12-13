@component('telescope-toolbar::item', ['name' => 'config', 'additional_classes' => 'sf-toolbar-block-right'])

    @slot('icon')

        @ttIcon('laravel')

        <span class="sf-toolbar-value">{{ app()->version() }}</span>

    @endslot

    @slot("text")
        <div class="sf-toolbar-info-group">
            <div class="sf-toolbar-info-piece">
                <b>Environment</b>
                <span>{{ app()->environment() }}</span>
            </div>

            <div class="sf-toolbar-info-piece">
                <b>Debug</b>
                <span class="sf-toolbar-status sf-toolbar-status-{{ config('app.debug') ? 'green' : 'red' }}">{{ config('app.debug') ? 'enabled' : 'disabled' }}</span>
            </div>

            <div class="sf-toolbar-info-group">
                <div class="sf-toolbar-info-piece sf-toolbar-info-php">
                    <b>PHP version</b>
                    <span>{{ phpversion() }}</span>
                </div>
                <div class="sf-toolbar-info-piece sf-toolbar-info-php">
                    <b>Laravel version</b>
                    <span>{{ app()->version() }}</span>
                </div>
            </div>
        </div>

    @endslot
@endcomponent
