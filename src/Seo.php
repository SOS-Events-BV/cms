<?php

namespace SOSEventsBV\Cms;

use Illuminate\Support\Arr;

class Seo
{
    /**
     * Get the canonical URL.
     *
     * @param  array<int, string>  $containParams  Can contain query parameters to include in the canonical URL.
     * @return string The canonical URL.
     */
    public function canonical(array $containParams = ['page']): string
    {
        $query = Arr::only(request()->query(), $containParams);

        if ($query === []) {
            return url()->current();
        }

        return url()->current().'?'.Arr::query($query);
    }
}
