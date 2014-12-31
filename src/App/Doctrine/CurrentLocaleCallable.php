<?php

namespace App\Doctrine;

use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\HttpFoundation\RequestStack;

class CurrentLocaleCallable
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param Translatable $entity
     * @return string
     */
    public function __invoke($entity)
    {
        $request = $this->requestStack->getMasterRequest();

        if ($entity->getTranslations()->count() === 1) {
            return $entity->getTranslations()[0]->getLocale();
        }

        return $request->getLocale();
    }
}
