<?php

namespace SOSEventsBV\Cms;

use Cocosmos\FilamentStickySaveBar\Enums\ShowOn;
use Cocosmos\FilamentStickySaveBar\StickySaveBarPlugin;
use Composer\InstalledVersions;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Models\SocialiteUser;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Actions\Action;
use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\Support\Icons\Heroicon;
use Pboivin\FilamentPeek\FilamentPeekPlugin;
use SOSEventsBV\Cms\Pages\ManageCompany;
use SOSEventsBV\Cms\Resources\Categories\CategoryResource;
use SOSEventsBV\Cms\Resources\Events\EventResource;
use SOSEventsBV\Cms\Resources\FaqPageQuestions\FaqPageQuestionResource;
use SOSEventsBV\Cms\Resources\Pages\PageResource;
use SOSEventsBV\Cms\Resources\Products\ProductResource;
use SOSEventsBV\Cms\Resources\Redirects\RedirectResource;
use SOSEventsBV\Cms\Resources\Reviews\ReviewResource;
use SOSEventsBV\Cms\Widgets\LastEditedPages;
use SOSEventsBV\Cms\Widgets\ReviewStats;
use Filament\Support\Enums\Platform;

class CmsPlugin implements Plugin
{
    protected bool $withReviews = true;
    protected bool $withFaq = true;
    protected bool $withEvents = true;
    protected bool $withProducts = true;

    protected array $additionalPageInputs = [];

    public function withoutReviews(): self
    {
        $this->withReviews = false;
        return $this;
    }

    public function withoutFaq(): self
    {
        $this->withFaq = false;
        return $this;
    }

    public function withoutEvents(): self
    {
        $this->withEvents = false;
        return $this;
    }

    public function withoutProducts(): self
    {
        $this->withProducts = false;
        return $this;
    }

    public function additionalPageInputs(array $inputs): self
    {
        $this->additionalPageInputs = $inputs;
        return $this;
    }

    public function getAdditionalPageInputs(): array
    {
        return $this->additionalPageInputs;
    }

    public function getId(): string
    {
        return 'cms';
    }

    public function register(Panel $panel): void
    {
        $resources = [
            PageResource::class,
            RedirectResource::class,
        ];

        if ($this->withReviews) $resources[] = ReviewResource::class;
        if ($this->withFaq) $resources[] = FaqPageQuestionResource::class;
        if ($this->withEvents) $resources[] = EventResource::class;
        if ($this->withProducts) {
            $resources[] = CategoryResource::class;
            $resources[] = ProductResource::class;
        }

        $panel
            ->plugins([
                FilamentPeekPlugin::make(),
            ])
            ->pages([
                ManageCompany::class
            ])
            ->resources($resources)
            ->navigationGroups([
                NavigationGroup::make()->label('Pagina\'s'),
                NavigationGroup::make()->label('Producten'),
                NavigationGroup::make()->label('Instellingen'),
            ])
            ->spa() // Transitions between pages, smooth experience
            ->unsavedChangesAlerts() // Alert when changes are made and you wan't to quit the page
            ->sidebarCollapsibleOnDesktop() // Hide menu on desktop
            ->userMenuItems([
                [
                    // View website button
                    Action::make('viewSite')
                        ->label('Bekijk website')
                        ->url(config('app.url'))
                        ->icon(Heroicon::GlobeAlt)
                        ->openUrlInNewTab(),

                    // Manage password/MFA at Microsoft, only for users that logged in with Microsoft
                    Action::make('manageMicrosoftAccount')
                        ->label('Microsoft-account beheren')
                        ->url('https://myaccount.microsoft.com')
                        ->icon('cms-microsoft')
                        ->openUrlInNewTab()
                        ->visible(fn(): bool => once(fn(): bool => SocialiteUser::query()
                            ->where('user_id', auth()->id())
                            ->where('provider', 'microsoft')
                            ->exists())),
                ],
                [
                    // CMS version, helpful for support questions
                    Action::make('cmsVersion')
                        ->label('CMS ' . (InstalledVersions::getPrettyVersion('sos-events-bv/cms') ?? 'onbekend'))
                        ->icon(Heroicon::InformationCircle)
                        ->disabled(),
                ]
            ])
            ->widgets([
                ReviewStats::class,
                LastEditedPages::class
            ])
            ->plugins([
                StickySaveBarPlugin::make()
                    ->showOn(ShowOn::Dirty),

                FilamentSocialitePlugin::make()
                    ->providers([
                        Provider::make('microsoft')
                            ->label('Microsoft')
                            ->icon('cms-microsoft')
                            ->color('#2f2f2f'),
                    ])
                    ->registration(true),
            ])
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchFieldSuffix(fn(): ?string => match (Platform::detect()) {
                Platform::Windows, Platform::Linux => 'CTRL+K',
                Platform::Mac => '⌘K',
                default => null,
            });
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
