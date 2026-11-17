<?php

namespace SOSEventsBV\Cms;

use BladeUI\Icons\Factory as IconFactory;
use Illuminate\Support\Facades\Event;
use Illuminate\View\Compilers\BladeCompiler;
use SOSEventsBV\Cms\Commands\CreateCustomBlock;
use SOSEventsBV\Cms\Commands\FetchCurrencies;
use SOSEventsBV\Cms\Commands\FetchReviews;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Microsoft\MicrosoftExtendSocialite;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use DutchCodingCompany\FilamentSocialite\Events\Login;

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

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        // Set Microsoft Entra values in config file
        config()->set('services.microsoft', [
            ...config('cms.services.microsoft'),
            'redirect' => rtrim(config('app.url'), '/') . '/admin/oauth/callback/microsoft',
        ]);
    }

    public function packageBooted(): void
    {
        // Register the Microsoft driver for Socialite (used for Microsoft login in Filament)
        Event::listen(SocialiteWasCalled::class, [MicrosoftExtendSocialite::class, 'handle']);

        // Sync the app roles and profile photo from Microsoft Entra ID on every successful login.
        Event::listen(Login::class, function (Login $event) {
            $avatar = $event->oauthUser->avatar ?? null;

            $event->socialiteUser->getUser()->update([
                'roles' => $event->oauthUser->roles ?? [],
                'avatar' => $avatar ? 'data:image/jpeg;base64,' . $avatar : null,
            ]);
        });

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

        // Register the package's SVG icons (e.g. `cms-microsoft`)
        $this->callAfterResolving(IconFactory::class, function (IconFactory $factory) {
            $factory->add('cms', [
                'path' => __DIR__ . '/../resources/svg',
                'prefix' => 'cms',
            ]);
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
