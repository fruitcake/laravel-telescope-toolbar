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

        $request = $this->entries->get('request', $options)->first();

        return View::make('telescope-toolbar::toolbar', [
            'request' =>  $request ? $request->content : null,
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

}