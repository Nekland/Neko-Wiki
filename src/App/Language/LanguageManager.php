<?php

namespace App\Language;


use Symfony\Component\HttpFoundation\RequestStack;

class LanguageManager
{
    static protected $languages = [
        'fr' => 'français',
        'en' => 'english'
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
        $this->supportedLanguages = $supportedLanguages;
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

    /*
    public function init()
    {
        $request = $this->requestStack->getMasterRequest();

        // try to see if the locale has been set as a _locale routing parameter
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $request->getPreferredLanguage());
        } else {
            // if no explicit locale has been set on this request, use one from the session
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLanguage));
        }
    }
    */

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
}
