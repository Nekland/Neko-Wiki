<?php

namespace Nekland\NekoWiki\Application\Translation;

use Nekland\NekoWiki\Application\Exception\UnsupportedLanguageException;
use Symfony\Component\HttpFoundation\RequestStack;

class LanguageManager
{
    static protected $languages = [
        'fr' => 'français',
        'en' => 'english'
    ];

    static protected $flag = [
        'en' => 'us'
    ];

    /**
     * @var array
     */
    private $supportedLanguages;

    /**
     * @var string
     */
    private $defaultLanguage;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack, $defaultLanguage, array $supportedLanguages)
    {
        $this->setSupportedLanguages($supportedLanguages);
        $this->requestStack = $requestStack;
        $this->defaultLanguage = $defaultLanguage;
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

    /**
     * @param string $language
     * @return string
     */
    public function getFlagImage($language)
    {
        if (isset(self::$flag[$language])) {
            $language = self::$flag[$language];
        }

        return $language . '.png';
    }

    /**
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * @return string
     */
    public function getCurrentLanguage()
    {
        return $this->requestStack->getMasterRequest()->getLocale();
    }

    private function setSupportedLanguages(array $supportedLanguages)
    {
        foreach ($supportedLanguages as $language) {
            if (!array_key_exists($language, self::$languages)) {
                throw new UnsupportedLanguageException();
            }
        }

        $this->supportedLanguages = $supportedLanguages;
    }
}
