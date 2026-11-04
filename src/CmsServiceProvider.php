<?php

namespace SOSEventsBV\Cms;

use Filament\Support\Assets\Asset;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\View\Compilers\BladeCompiler;
use SOSEventsBV\Cms\Commands\CreateCustomBlock;
use SOSEventsBV\Cms\Commands\FetchCurrencies;
use SOSEventsBV\Cms\Commands\FetchReviews;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CmsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'cms';

    public static string $viewNamespace = 'cms';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->discoversMigrations()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->endWith(function (InstallCommand $command) {
                        $command->call('filament:assets');
                    });
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        //
    }

    public function packageBooted(): void
    {
        // Load translation overrides for other packages from lang/vendor/{namespace}
        $this->callAfterResolving('translation.loader', function ($loader) {
            $loader->addPath(__DIR__ . '/../lang');
        });

        // Register routes after all other service providers, so catch-all routes are last
        $this->app->booted(function () {
            if (config('cms.routing.register_catch_all', true)) {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            }
        });

        // Add components to the website of the user
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $blade->componentNamespace('SOSEventsBV\\Cms\\Components', 'cms');
        });
    }

    protected function getAssetPackageName(): ?string
    {
        return 'sos-events-bv/cms';
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FetchCurrencies::class,
            FetchReviews::class,
            CreateCustomBlock::class,
        ];
    }
}
