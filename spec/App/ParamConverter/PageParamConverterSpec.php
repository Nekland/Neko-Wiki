<?php

namespace spec\App\ParamConverter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageParamConverterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface');
    }

    /**
     * @param \App\Provider\PageProvider $pageProvider
     * @param \App\Entity\Page           $page
     */
    public function let($pageProvider, $page)
    {
        $pageProvider->findPageBySlug(Argument::any())->willReturn($page);
        $this->beConstructedWith($pageProvider);
    }

    /**
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     */
    public function it_should_support_page_parameter_and_page_entity($configuration)
    {
        $configuration->getClass()->willReturn('App\Entity\Page');
        $configuration->getName()->willReturn('page');
        $this->supports($configuration)->shouldReturn(true);
    }

    /**
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     */
    public function it_should_not_support_another_parameter($configuration)
    {
        $configuration->getClass()->willReturn('App\Entity\Page');
        $configuration->getName()->willReturn('foo_parameter');
        $this->supports($configuration)->shouldReturn(false);
    }

    /**
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     */
    public function it_should_not_support_another_class($configuration)
    {
        $configuration->getClass()->willReturn('App\Entity\User\User');
        $configuration->getName()->willReturn('page');
        $this->supports($configuration)->shouldReturn(false);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request                        $request
     * @param \Symfony\Component\DependencyInjection\ParameterBag\ParameterBag $parameterBag
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     * @param \App\Entity\Page                                                 $page
     */
    public function it_should_return_a_page_when_apply($request, $parameterBag, $configuration, $page)
    {
        $request->attributes = $parameterBag;
        $parameterBag->get(Argument::any())->willReturn('home');
        $parameterBag->set('page', $page)->shouldBeCalled();

        $this->apply($request, $configuration)->shouldReturn(true);
    }
}
