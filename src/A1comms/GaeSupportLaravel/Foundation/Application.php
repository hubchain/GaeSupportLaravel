<?php

namespace A1comms\GaeSupportLaravel\Foundation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Foundation\ProviderRepository as LaravelProviderRepository;

class Application extends LaravelApplication
{
    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($basePath = null)
    {
        return parent::__construct($basePath);
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        if (is_gae()) {
            (new ProviderRepository())
                        ->load($this->config['app.providers']);
        } else {
            $manifestPath = $this->getCachedServicesPath();
            (new LaravelProviderRepository($this, new Filesystem, $manifestPath))
                        ->load($this->config['app.providers']);
        }
    }
}