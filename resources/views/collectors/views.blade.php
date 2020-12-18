<?php
/**
 * @var \Illuminate\Support\Collection|\Laravel\Telescope\EntryResult[] $entries
 */

$views = [];
$total = 0;
foreach ($entries as $entry) {
    $name = $entry->content['name'];

    if (isset($views[$name])) {
        $views[$name]['num']++;
    }

    $views[$name] = [
        'id' => $entry->id,
        'name' => $name,
        'path' => $entry->content['path'] ?? '',
        'num' => 1,
    ];
    $total++;
}

$views = collect($views)->reverse();

?>
@component('telescope-toolbar::item', ['name' => 'views', 'link' => true])

    @slot('icon')
        @ttIcon('views')

        <span class="sf-toolbar-value">{{ $total }}</span>

    @endslot

    @slot('text')

        <div class="sf-toolbar-info-piece">
            <table class="sf-toolbar-previews">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Path</th>
                        <th>Num</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($views as $view)
                    <tr >
                        <td>
                            <a href="{{ route('telescope') }}/views/{{ $view['id'] }}" target="_telescope">
                                {{ \Illuminate\Support\Str::limit($view['name'], 40) }}
                            </a>
                        </td>

                        <td title="{{ $view['path'] }}">
                            {{ \Illuminate\Support\Str::limit($view['path'], 40) }}
                        </td>

                        <td>
                            {{ $view['num'] }}
                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    @endslot


@endcomponent