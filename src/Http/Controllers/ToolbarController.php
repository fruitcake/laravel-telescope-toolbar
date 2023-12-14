<?php

namespace Fruitcake\TelescopeToolbar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Laravel\Telescope\Contracts\EntriesRepository;
use Laravel\Telescope\Storage\EntryQueryOptions;
use Laravel\Telescope\Telescope;

class ToolbarController extends Controller
{
    /**
     * @var \Laravel\Telescope\Contracts\EntriesRepository
     */
    private $entriesRepository;

    public function __construct(EntriesRepository $entriesRepository)
    {
        $this->entriesRepository = $entriesRepository;

        $this->middleware(function($request, $next) {
            Telescope::stopRecording();

            if ($request->hasSession()) {
                $request->session()->reflash();
            }

            return $next($request);
        });
    }

    public function render($token)
    {
        $this->prepareBlade($token);

        $options = $this->findBatchOptions($token);

        $entries = $this->entriesRepository->get(null, $options)->groupBy('type');

        return View::make('telescope-toolbar::toolbar', [
            'entries' => $entries,
        ]);
    }

    public function show($token)
    {
        $options = $this->findBatchOptions($token);

        $request = $this->entriesRepository->get('request', $options)->first();

        return redirect(route('telescope') . '/requests/' . $request->id);
    }

    public function baseJs()
    {
        $content = View::make('telescope-toolbar::base_js', [
            'excluded_ajax_paths' => config('telescope-toolbar.excluded_ajax_paths', '^/_tt'),
        ])->render();

        $content = $this->stripSurroundingTags($content);

        return response($content, 200, [
            'Content-Type' => 'text/javascript',
        ])->setClientTtl(31536000);
    }

    public function styling(Request $request)
    {
        if ($request->get('lightMode')) {
            $files = ['theme_light.css'];
        } else {
            $files = [
                'base.css',
                'custom.css',
            ];
        }

        $content = '';
        foreach ($files as $file) {
            $content .= File::get(__DIR__ . '/../../../resources/css/' . $file) . "\n";
        }

        return response($content, 200, [
            'Content-Type' => 'text/css',
        ])->setClientTtl(31536000);
    }

    /**
     * Strip <script>/<style> tags from the content
     *
     * @param $content
     * @return string
     */
    private function stripSurroundingTags($content)
    {
        $lines = explode("\n", trim($content));

        array_shift($lines);
        array_pop($lines);

        return implode("\n", $lines);
    }

    /**
     * Make sure Blade has the correct Directives and shares the Token
     *
     * @param $token
     */
    private function prepareBlade($token)
    {
        View::share('token', $token);

        Blade::directive('ttIcon', function ($expression) {
            $dir = realpath(__DIR__ . '/../../../resources/icons');
            return "<?php echo file_get_contents('$dir/' . basename($expression) . '.svg'); ?>";
        });

    }

    /**
     * Find the search options for the related entries.
     *
     * @param $token
     *
     * @return \Laravel\Telescope\Storage\EntryQueryOptions
     */
    private function findBatchOptions($token) : EntryQueryOptions
    {
        $entry = $this->entriesRepository->find($token);

        return EntryQueryOptions::forBatchId($entry->batchId)->limit(-1);
    }
}
