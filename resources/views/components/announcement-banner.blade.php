@if($announcements->isNotEmpty())
    <div class="container mx-auto flex flex-col gap-3">
        @foreach($announcements as $announcement)
            <div class="announcement {{ $announcement->type->getCssClass() }} p-5 rounded-lg flex justify-between items-center flex-wrap gap-3">
                <div>
                    <p class="text-2xl mb-3 md:mb-0"><i class="{{ $announcement->type->getFaIcon() }}"></i> {{ $announcement->title }}</p>
                    <div class="text-format">{!! $announcement->message !!}</div>
                </div>

                @if(filled($announcement->button_text) && filled($announcement->button_url))
                    <a
                        class="announcement-button px-3 py-1 rounded-full transition-all text-md"
                        href="{{ $announcement->button_url }}"
                    >{{ $announcement->button_text }}</a>
                @endif
            </div>
        @endforeach
    </div>
@endif
