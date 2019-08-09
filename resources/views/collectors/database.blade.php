
@component('telescope-toolbar::item', ['name' => 'database', 'link' => true])

    @slot('icon')
        @ttIcon('database')

        <span class="sf-toolbar-value">{{ $data['num_queries'] }}</span>

        <span class="sf-toolbar-info-piece-additional-detail">
            <span class="sf-toolbar-label">in</span>
            <span class="sf-toolbar-value">{{ $data['query_time'] }}</span>
            <span class="sf-toolbar-label">ms</span>
        </span>

    @endslot

    @slot('text')

        <div class="sf-toolbar-info-piece">
            <b>Database Queries</b>
            <span class="sf-toolbar-status ">{{ $data['num_queries'] }}</span>
        </div>

        <div class="sf-toolbar-info-piece">
            <b>Slow Queries</b>
            <span class="sf-toolbar-status ">{{ $data['num_slow'] }}</span>
        </div>

        <div class="sf-toolbar-info-piece">
            <b>Query time</b>
            <span>{{ $data['query_time'] }} ms</span>
        </div>

    @endslot

@endcomponent