<?php

namespace Fruitcake\TelescopeToolbar\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\EntryResult;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Storage\EntryQueryOptions;
use Laravel\Telescope\Telescope;

class ToolbarController extends Controller
{
    protected $entry = [];
    protected $entries;

    public function __construct(EntriesRepository $entriesRepository)
    {
        $this->entries = $entriesRepository;
    }

    public function render($token)
    {
        Telescope::stopRecording();

        $entry = $this->findToolbarEntry($token);

        View::share('token', $token);

        Blade::directive('ttIcon', function ($expression) {
            $dir = realpath(__DIR__ . '/../../../resources/icons');
            return "<?php echo file_get_contents('$dir/' . basename($expression) . '.svg'); ?>";
        });

        return View::make('telescope-toolbar::toolbar', [
            'request' =>  $this->getRequestData($token),
            'database' => $this->getDatabaseData($token),
            'redirect' => $this->getRequestData($entry->content['redirect_token'] ?? null),
        ]);
    }

    public function show($token)
    {
        Telescope::stopRecording();

        $options = $this->findBatchOptions($token);

        $request = $this->entries->get('request', $options)->first();

        return redirect(route('telescope') . '/requests/' . $request->id);
    }

    protected function findToolbarEntry($token) : EntryResult
    {
        if (!isset($this->entry[$token])) {
            $this->entry[$token] = $this->entries->find($token);
        }

        return $this->entry[$token];
    }

    protected function findBatchOptions($token) : EntryQueryOptions
    {
        return (new EntryQueryOptions())->batchId($this->findToolbarEntry($token)->batchId);
    }

    protected function getRequestData($token)
    {
        if (!$token) {
            return;
        }

        $options = $this->findBatchOptions($token);

        $request = $this->entries->get('request', $options)->first();

        if ($request) {
            $request->content['token'] = $token;
            return $request->content;
        }
    }

    protected function getDatabaseData($token)
    {
        $options = $this->findBatchOptions($token);

        $queries =  $this->entries->get('query', $options);

        $data = [
            'num_queries' => 0,
            'num_slow' => 0,
            'query_time' => 0,
        ];

        foreach ($queries as $query) {
            $data['num_queries']++;
            if ($query->content['slow'] ?? false) {
                $data['num_slow']++;
            }
            $data['query_time'] += $query->content['time'] ?? 0;
        }

        return $data;
    }

}