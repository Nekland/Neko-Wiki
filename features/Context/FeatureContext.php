<?php

namespace Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Behat context class.
 */
class FeatureContext extends MinkContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {

    }

    /**
     * @Given my current language is :arg1
     */
    public function myCurrentLanguageIs($arg1)
    {
        $this->visit('/en/article/home.html');
    }
}
