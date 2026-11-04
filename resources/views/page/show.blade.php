<x-dynamic-component
    :component="config('cms.layout')"
    :title="$page->seo?->page_title"
    :description="$page->seo?->page_description"
    :keywords="$page->seo?->page_keywords"
    :og_title="$page->seo?->og_title"
    :og_description="$page->seo?->og_description"
    :og_image="$page->seo?->og_image"
>
    <div class="container py-10">
        <div class="text-format">
            @foreach ($page->content_objects as $block)
                @php($blockView = str_replace('_', '-', $block->type))
                @if(view()->exists("cms::components.blocks.{$blockView}"))
                    <x-dynamic-component :component="'cms::blocks.' . $block->type" :data="$block->data"/>
                @elseif(view()->exists("components.cms.custom-blocks.{$blockView}"))
                    <x-dynamic-component :component="'cms.custom-blocks.' . $block->type" :data="$block->data"/>
                @endif
            @endforeach
        </div>
    </div>
</x-dynamic-component>
