<?php

namespace App\Provider;


class LanguageProvider
{
    static protected $languages = [
        'fr' => 'français',
        'en' => 'english'
    ];

    /**
     * @var array
     */
    private $supportedLanguages;

    public function __construct(array $supportedLanguages)
    {
        $this->supportedLanguages = $supportedLanguages;
    }

    /**
     * @return array
     */
    public function getLanguages()
    {
        $res = [];

        foreach (static::$languages as $abbr => $lang) {
            if (in_array($abbr,$this->supportedLanguages)) {
                $res[$abbr] = $lang;
            }
        }

        return $res;
    }
}
