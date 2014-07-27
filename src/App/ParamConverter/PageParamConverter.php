<?php

namespace App\ParamConverter;


use App\Provider\PageProvider;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class PageParamConverter implements ParamConverterInterface
{
    /**
     * @var \App\Provider\PageProvider
     */
    private $provider;

    public function __construct(PageProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool    True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $slug = $request->attributes->get('page_slug');
        $page = $this->provider->findPageBySlug($slug);

        $request->attributes->set('page', $page);

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool    True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() == 'App\Entity\Page' && $configuration->getName() === 'page';
    }

}
