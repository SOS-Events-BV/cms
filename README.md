# CMS for websites of SOS Events BV.

This package provides a CMS panel plugin for Filament for websites of SOS Events BV. This package contains a page
builder, product resource, company management and more.

## Installation

After adding the package to your project, you can install the plugin by running:

```bash
php artisan cms:install
```

This will ask if you want to publish the CMS views (see [Customizing views](#customizing-views)) and if you want to run
the migrations. If you haven't run the migrations yet, make sure you select yes. If you have already run the migrations,
please delete all tables and run the migrations again.

Because we make changes to the User model, we need to add the `HasCmsFields` trait to the User model. The User model
must also implement `HasAvatar`, so Filament shows the Microsoft avatar of the user. This can be done by adding the
following to the `App\Models\User` model:

```php
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use SOSEventsBV\Cms\Traits\HasCmsFields;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasCmsFields;

    // ... The rest of the User model
}
```

### Registering the plugin

Add the plugin to your Filament panel provider in `app/Providers/Filament/AdminPanelProvider.php`:

```php
use SOSEventsBV\Cms\CmsPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugins([
            CmsPlugin::make(),
        ]);
}
```

### Redirecting

The CMS has a redirect feature built in. If you want to have redirects, you must add the following to your
withMiddleware function in the `bootstrap/app.php` file:

```php
use SOSEventsBV\Cms\Middleware\HandleRedirects;

return Application::configure(basePath: dirname(__DIR__))
    // ...
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(HandleRedirects::class);
    })
    // ...
```

### Environment variables

We also have a few environment variables that are required for the plugin to work. You need to fill this in with your
own values and keys. Please add these to your `.env` file and `.env.example` file (but without the values 😉).

```dotenv
# LeisureKing API
CMS_LEISUREKING_API_URL="https://api.leisureking.eu/public"
CMS_LEISUREKING_API_VERSION="v4"
CMS_LEISUREKING_API_USERNAME=
CMS_LEISUREKING_API_PASSWORD=
CMS_LEISUREKING_API_ENVIRONMENT="production" # test or production, production is preferred
CMS_LEISUREKING_API_SHOPHID=

# Reviews API
CMS_REVIEW_API_URL="https://reageren.sosevents.nl/api"
CMS_REVIEW_API_KEY=
CMS_REVIEW_API_SHOP_ID=

# MailCampaigns API
CMS_MAILCAMPAIGNS_API_URL="https://api.mailcampaigns.nl/api/v2.0"
CMS_MAILCAMPAIGNS_API_KEY=
CMS_MAILCAMPAIGNS_API_TOKEN=

# SOS Events API
CMS_SOS_EVENTS_API_URL="https://api.sosevents.nl/v1"
CMS_SOS_EVENTS_API_KEY=
CMS_SOS_EVENTS_API_SECRET=

# Microsoft oAuth
CMS_MICROSOFT_CLIENT_ID=
CMS_MICROSOFT_CLIENT_SECRET=
CMS_MICROSOFT_TENANT_ID=

# ReCaptcha
CMS_RECAPTCHA_PROJECT_ID=
CMS_RECAPTCHA_SITE_KEY=
CMS_RECAPTCHA_API_KEY=
CMS_RECAPTCHA_THRESHOLD=

# Weglot
CMS_WEGLOT_AVAILABLE_LANGUAGES=nl,en,de
```

> **reCAPTCHA:** create a reCAPTCHA Enterprise key of the **checkbox** type in Google Cloud. The form renders the checkbox widget, so a score-based key (without checkbox) will not work. `CMS_RECAPTCHA_API_KEY` is a Google Cloud API key with access to the reCAPTCHA Enterprise API.

### Styling (optional)

The page view uses a `text-format` class for content formatting. Add the following to your CSS file:

```css
.text-format {
    @apply prose prose-headings:mb-4 prose-headings:not-first:mt-5
    prose-h3:font-normal prose-h4:font-normal prose-h5:font-normal prose-h6:font-normal
    [&>*:first-child]:mt-0 [&>*:first-child]:pt-0
    [&>*:last-child]:mb-0 [&>*:last-child]:pb-0
    max-w-none text-black;
}
```

Make sure you have the `@tailwindcss/typography` plugin installed.

Also, make sure that you add the following to your `app.css` file:

```css
@source '../../vendor/sos-events-bv/cms/**/*.{blade.php,php}';
```

This will make sure that the CSS of the page builder blocks is included in the build.

### Announcements

Announcements are site-wide messages that are managed in the CMS. Each announcement has a type
(info, warning or error), a title, a message, an optional button and a start and end date. An announcement is visible
from the start date up to and including the end date.

Place the announcement banner component where you want the announcements to appear, for example at the top of your
layout:

```blade
<x-cms::announcement-banner />
```

The colors of the announcements are not defined in the package, so every website can use its own colors. Each
announcement gets the class `announcement` and a class per type (`announcement-info`, `announcement-warning` or
`announcement-error`). The button gets the class `announcement-button`. Add the following to your `app.css` file and
change the colors to match your website:

```css
.announcement-info {
    @apply bg-blue-100 text-blue-800;
}

.announcement-info .announcement-button {
    @apply bg-blue-500 hover:bg-blue-700 text-white;
}

.announcement-warning {
    @apply bg-yellow-100 text-yellow-800;
}

.announcement-warning .announcement-button {
    @apply bg-yellow-500 hover:bg-yellow-700 text-white;
}

.announcement-error {
    @apply bg-red-100 text-red-800;
}

.announcement-error .announcement-button {
    @apply bg-red-500 hover:bg-red-700 text-white;
}
```

If you are using the [CMS Template](https://github.com/sos-events-bv/website-template), these styles are already
included. Announcements can be disabled with `->withoutAnnouncements()` (see [Optional features](#optional-features)).

## Layout

The plugin ships with a default layout (`cms::layout`), which is used to render the CMS pages. It contains the SEO and
Open Graph meta tags, loads `resources/css/app.css` and `resources/js/app.js` through Vite (when a build or dev server
is available) and includes Livewire. It also provides two stacks you can push to: `head` and `body`.

To customize the default layout, publish the views (see [Customizing views](#customizing-views)) and edit
`resources/views/vendor/cms/components/layout.blade.php`.

### Using your own layout component

You can also use your own layout component by changing it in the config:

```php
'layout' => 'layout', // x-layout
```

Your component must accept the following props:

```php
@props([
    'title' => config('app.name'),
    'description' => '',
    'keywords' => null,
    'og_title' => null,
    'og_description' => null,
    'og_image' => null,
])
```

If you are using the [CMS Template](https://github.com/sos-events-bv/website-template), this component is already
included.

## Customizing views

All views of the plugin (layout, page builder blocks, form fields, e-mails, etc.) can be published to your project, so
you can change them to match the style of your website:

```bash
php artisan vendor:publish --tag=cms-views
```

The views will be published to `resources/views/vendor/cms`. Laravel uses a published view instead of the one in the
package, and falls back to the package for every view that is not published. It is therefore recommended to only keep
the views you actually change, so the other views keep receiving updates from the package.

## Usage

### Optional features

By default, the plugin registers all resources. You can disable individual features when registering the plugin:

```php
CmsPlugin::make()
    ->withoutReviews()
    ->withoutFaq()
    ->withoutEvents()
    ->withoutProducts() // also disables Categories
    ->withoutAnnouncements(),
```

### Additional page fields

You can add your own fields to the page form with `additionalPageInputs()`. They are shown in an "Extra velden" section
below the page builder (the section is hidden when no fields are given):

```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

CmsPlugin::make()
    ->additionalPageInputs([
        TextInput::make('subtitle'),
        Toggle::make('show_in_footer'),
    ]),
```

The package does not create database columns for these fields, so add them to the `pages` table yourself with a
migration in your app:

```php
Schema::table('pages', function (Blueprint $table) {
    $table->string('subtitle')->nullable();
    $table->boolean('show_in_footer')->default(false);
});
```

The `Page` model only guards `id` and the timestamps, so the new columns are mass assignable without further changes.

### Page builder

Pages are built in the admin panel using a block-based editor. Each page's content is stored as a JSON array of typed
blocks. On the front end, the page view loops over `$page->content_objects` and renders each block as a Blade component:

```blade
@foreach ($page->content_objects as $block)
    {{-- CMS Components --}}
    @if(view()->exists("cms::components.blocks.{$block->type}"))
        <x-dynamic-component :component="'cms::blocks.' . $block->type" :data="$block->data"/>
    {{-- Own components --}}
    @elseif(view()->exists("components.cms.custom-blocks.{$block->type}"))
        <x-dynamic-component :component="'cms.custom-blocks.' . $block->type" :data="$block->data"/>
    @endif
@endforeach
```

The entire loop is wrapped in a `<div class="text-format">`, so your `text-format` CSS class applies to all block
output.

> **Do not use these components in your own views.** These blocks are specially made for the pagebuilder and
> will not work in 'normal' blade views. Exception is the form fields: these are recommended to use in views, because
> they have error handling built in.

### Using the page builder on your own models

If you want to use the page builder on a model other than `Page` (e.g. `Product`), add the `HasContentBlocks` trait:

```php
use SOSEventsBV\Cms\Traits\HasContentBlocks;

class Product extends Model
{
    use HasContentBlocks;

    protected $casts = ['content' => 'array'];
}
```

Then use `ContentBuilder::make('content', 'product')` in your Filament form schema (the second argument is the upload
directory for image blocks) and render with `$product->content_objects` in your Blade view.

If the content field is named differently, override `contentBlocksField()` in your model:

```php
protected function contentBlocksField(): string
{
    return 'description';
}
```

### Form builder

Pages with a `FormBuilderBlock` get a form at `/{slug}/submit`. On successful submission the visitor is redirected to
`/{slug}/success`. The block stores the recipient email address and the success title/message — no additional
configuration is needed.

### Adding your own catch-all routes

The package registers its own catch-all routes (`/{slug}`, `/{slug}/submit`, `/{slug}/success`) as the very last
routes in the application, so any specific route you define in your own app already takes priority over them.

If you also want your own catch-all route (e.g. to resolve slugs against your own models before falling back to
CMS pages), disable the package's catch-all routes in `config/cms.php`:

```php
'routing' => [
    // ...
    'register_catch_all' => false,
],
```

Then define your own catch-all route and call `PageController` yourself as the final fallback:

```php
use SOSEventsBV\Cms\Http\Controllers\PageController;

Route::get('/{slug}', function (string $slug) {
    if ($event = Event::where('slug', $slug)->first()) {
        return view('events.show', ['event' => $event]);
    }

    // Nothing of our own matched, let the CMS try to find a page
    return app(PageController::class)->show($slug);
})->where('slug', '.+');
```

`PageController::show()`, `submitForm()` and `showSuccess()` are plain, stateless methods, so you can call them
directly like this regardless of `register_catch_all`.

### Routes config

The `routes` array in `config/cms.php` maps resource types to named routes in your application. These are used to
show a "View on site" button in the admin panel. Set a value to `null` to hide the button for that resource. By default,
all routes except `page` are `null`. For example:

```php
'routes' => [
    'page'     => 'page',      // route('page', $slug)
    'category' => 'category',  // route('category', $slug)
    'product'  => 'product',   // route('product', $slug)
    'reviews'  => 'reviews',
    'faq'      => 'faq',
    'events'   => 'events',
    'products' => 'products',
],
```
