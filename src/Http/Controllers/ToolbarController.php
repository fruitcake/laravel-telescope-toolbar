<?php

namespace Fruitcake\TelescopeToolbar\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\Storage\EntryQueryOptions;
use Laravel\Telescope\Telescope;

class ToolbarController extends Controller
{
    protected $requestId;
    protected $entries;

    public function __construct(EntriesRepository $entriesRepository)
    {
        $this->entries = $entriesRepository;
    }

    public function render($token)
    {
        Telescope::stopRecording();

        $options = $this->findBatchOptions($token);

        View::share('token', $token);

        return View::make('telescope-toolbar::toolbar', [
            'request' =>  $this->getRequestData($options),
            'database' => $this->getDatabaseData($options),
        ]);
    }

    public function show($token)
    {
        Telescope::stopRecording();

        $options = $this->findBatchOptions($token);

        $request = $this->entries->get('request', $options)->first();

        return redirect(route('telescope') . '/requests/' . $request->id);
    }

    protected function findRequestId($token) : string
    {
        if ($this->requestId === null) {
            $entry = $this->entries->find($token);

            $this->requestId = $entry->batchId;
        }

        return $this->requestId;
    }

    protected function findBatchOptions($token) : EntryQueryOptions
    {
        return (new EntryQueryOptions())->batchId($this->findRequestId($token));
    }

    protected function getRequestData($options)
    {
        $request = $this->entries->get('request', $options)->first();

        if ($request) {
            return $request->content;
        }
    }

    protected function getDatabaseData($options)
    {
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