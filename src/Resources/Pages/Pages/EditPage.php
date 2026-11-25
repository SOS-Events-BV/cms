<?php

namespace SOSEventsBV\Cms\Resources\Pages\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use SOSEventsBV\Cms\Models\Page;
use SOSEventsBV\Cms\Resources\Pages\PageResource;
use Throwable;

/**
 * @property Page $record
 */
class EditPage extends EditRecord
{
    // This adds the preview modal to this page
    use HasPreviewModal;

    public string $originalSlug = ''; // Original slug before saving

    /**
     * Overwrite the mount method to store the original slug, so we can check later if the slug has changed.
     *
     * @param int|string $record
     * @return void
     */
    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Store the original slug so we can compare it when saving
        $this->originalSlug = $this->record->slug;
    }

    protected static string $resource = PageResource::class;

    /**
     * Overwrite the preview modal view to use the show view.
     *
     * @return string|null
     */
    protected function getPreviewModalView(): ?string
    {
        return 'cms::page.show'; // ← namespace toevoegen
    }

    /**
     * Overwrite the preview modal data record key to use the page record.
     *
     * This changes the key in the preview to $page
     *
     * @param array $data
     * @return array
     */
    protected function mutatePreviewModalData(array $data): array
    {
        $data['page'] = $this->record->toArray();

        return $data;
    }

    /**
     * Overwrite the preview modal view.
     *
     * TODO: This is a hack to make the preview work. We should find a better way to do this.
     *
     * @throws Throwable
     */
    public static function renderPreviewModalView(string $view, array $data): string
    {
        if (isset($data['page']) && is_array($data['page'])) {
            $page = new Page();
            $page->forceFill($data['page']);
            $page->exists = true;
            $data['page'] = $page;
        }

        return view('cms::page.show', $data)->render();
    }


    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(), // This adds the preview button to the page
            DeleteAction::make()
        ];
    }

    /**
     * Overwrite the save form action to add a modal for slug changes. If the slug has changed,
     * the modal will be shown to remind the user to create a redirect.
     *
     * @return Action
     **/
    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label(__('cms::pages.slug_modal.save'))
            ->requiresConfirmation()
            ->modalHidden(fn() => $this->originalSlug === ($this->data['slug'] ?? ''))
            ->modalHeading(__('cms::pages.slug_modal.heading'))
            ->modalDescription(fn() => __('cms::pages.slug_modal.description', ['old' => $this->originalSlug, 'new' => $this->data['slug']]))
            ->modalSubmitActionLabel(__('cms::pages.slug_modal.submit'))
            ->modalCancelActionLabel(__('cms::pages.slug_modal.cancel'))->action(function () {
                $slugChanged = $this->originalSlug !== ($this->data['slug'] ?? '');

                // Update tracked slug, so re-saving without changes won't trigger the modal again
                $this->originalSlug = $this->data['slug'];
                $this->save();

                // Remind the user to create a redirect for the old slug
                if ($slugChanged) {
                    Notification::make()
                        ->warning()
                        ->title(__('cms::pages.slug_modal.notification.title'))
                        ->body(__('cms::redirects.reminder.body'))
                        ->persistent()
                        ->actions([
                            Action::make('createRedirect')
                                ->label(__('cms::redirects.reminder.button'))
                                ->button()
                                ->url(route('filament.admin.resources.redirects.index'))
                        ])
                        ->send();
                }
            })
            ->keyBindings(['mod+s']);
    }
}
