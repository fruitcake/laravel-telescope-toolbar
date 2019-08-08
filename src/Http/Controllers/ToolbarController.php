<?php

namespace Fruitcake\TelescopeToolbar\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\Storage\EntryQueryOptions;
use Laravel\Telescope\Telescope;

class ToolbarController extends Controller
{
    protected $entries;

    public function __construct(EntriesRepository $entriesRepository)
    {
        $this->entries = $entriesRepository;
    }

    public function render($token)
    {
        Telescope::stopRecording();

        return View::make('telescope-toolbar::toolbar', [
            'token' => $token,
        ]);
    }

    public function show($token)
    {
        Telescope::stopRecording();

        $request = $this->entries->get('request', $this->findBatchOptions($token))->first();

        return redirect(route('telescope') . '/requests/' . $request->id);
    }

    protected function findBatchOptions($token) : EntryQueryOptions
    {
        $entry = $this->entries->find($token);

        return (new EntryQueryOptions())->batchId($entry->batchId);
    }

}