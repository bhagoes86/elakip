<?php

namespace App\Http\Controllers\Privy;

use App\Models\Media;
use Barryvdh\Elfinder\Connector;
use Carbon\Carbon;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class MediaController extends AdminController
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
    }

    public function store(Request $request)
    {
        $file = $request->file('file');

        if($file->isValid())
        {
            $destination = base_path() . '/public/files/' . $request->get('destination');
            $originalName       = $file->getClientOriginalName();
            $extension          = $file->getClientOriginalExtension();
            $size               = $file->getClientSize();
            $getMaxFileSize     = $file->getMaxFilesize();
            $newFileName        = Carbon::now()->timestamp . '-' . Str::slug(str_replace($extension, '',$originalName)) . '.' . $extension;
            $uploaded           = $file->move($destination, $newFileName);
            $hashUploaded       = sha1_file($destination. '/' . $newFileName);

            $nFiles = Media::where('hash', $hashUploaded)->count();

            if($nFiles < 1)
            {
                $media = Media::create([
                    'name'  => $newFileName,
                    'original_name' => $originalName,
                    'size'  => $size,
                    'mime'  => $uploaded->getMimeType(),
                    'hash'  => $hashUploaded,
                    'ext'   => $extension,
                    'location'  => 'files/' .$request->get('destination') . '/'. $newFileName
                ]);
            }
            else
            {
                $media = Media::where('hash', $hashUploaded)->first();
            }

            return $media;

        }
    }

    /**
     * Elfinder connector
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @author Fathur Rohman <fathur@dragoncapital.center>
     */
    public function showConnector()
    {
        $roots = $this->app->config->get('elfinder.roots', []);
        if (empty($roots)) {
            $dirs = (array) $this->app['config']->get('elfinder.dir', []);
            foreach ($dirs as $dir) {
                $roots[] = [
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => public_path($dir), // path to files (REQUIRED)
                    'URL' => url($dir), // URL to files (REQUIRED)
                    'accessControl' => $this->app->config->get('elfinder.access'), // filter callback (OPTIONAL)
                    'attribute' => [
                        array(
                            'read'    => true,
                            'write'   => true,
                            'locked'  => false
                        )
                    ]
                ];
            }

            $disks = (array) $this->app['config']->get('elfinder.disks', []);
            foreach ($disks as $key => $root) {
                if (is_string($root)) {
                    $key = $root;
                    $root = [];
                }
                $disk = app('filesystem')->disk($key);
                if ($disk instanceof FilesystemAdapter) {
                    $defaults = [
                        'driver' => 'Flysystem',
                        'filesystem' => $disk->getDriver(),
                        'alias' => $key,
                    ];
                    $roots[] = array_merge($defaults, $root);
                }
            }
        }

        $opts = $this->app->config->get('elfinder.options', array());
        $opts = array_merge(['roots' => $roots], $opts);

        // run elFinder
        $connector = new Connector(new \elFinder($opts));
        $connector->run();
        return $connector->getResponse();
    }
}
