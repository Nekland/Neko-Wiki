<?php

namespace spec\App\ParamConverter;

use App\Entity\Page;
use App\Provider\PageProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class PageParamConverterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface');
    }

    public function let(PageProvider $pageProvider, Page $page)
    {
        $pageProvider->findPageBySlugAndCulture(Argument::any(), Argument::any())->willReturn($page);
        $this->beConstructedWith($pageProvider);
    }

    public function it_should_support_page_parameter_and_page_entity(ParamConverter $configuration)
    {
        $configuration->getClass()->willReturn('App\Entity\Page');
        $configuration->getName()->willReturn('page');
        $this->supports($configuration)->shouldReturn(true);
    }

    public function it_should_not_support_another_parameter(ParamConverter $configuration)
    {
        $configuration->getClass()->willReturn('App\Entity\Page');
        $configuration->getName()->willReturn('foo_parameter');
        $this->supports($configuration)->shouldReturn(false);
    }

    public function it_should_not_support_another_class(ParamConverter $configuration)
    {
        $configuration->getClass()->willReturn('App\Entity\User\User');
        $configuration->getName()->willReturn('page');
        $this->supports($configuration)->shouldReturn(false);
    }

    public function it_should_return_a_page_when_apply(Request $request, ParameterBag $parameterBag, ParamConverter $configuration, Page $page)
    {
        $request->attributes = $parameterBag;
        $parameterBag->get(Argument::any())->willReturn('home');
        $parameterBag->get(Argument::any(), Argument::any())->willReturn('fr');
        $parameterBag->set('page', $page)->shouldBeCalled();

        $this->apply($request, $configuration)->shouldReturn(true);
    }
}
