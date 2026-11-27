<?php

namespace SOSEventsBV\Cms;

class Weglot
{
    /**
     * Returns the current language set by Weglot.
     *
     * @return string
     */
    public function language(): string
    {
            return request()->header('weglot-language', app()->getLocale());
    }

    /**
     * Checks if the current language is the given language.
     * @param string $lang The language code to check.
     * @return bool True if the language is the current language, false otherwise.
     */
    public function is(string $lang): bool
    {
        return $this->language() === strtolower($lang);
    }
}
