<?php

namespace spec\App\Provider;

use App\Entity\Page;
use App\Entity\PageTranslation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Provider\PageProvider');
    }

    function let(EntityManager $em, EntityRepository $repo, PageTranslation $translation, Page $page)
    {
        $this->beConstructedWith($em);
        $em->getRepository(Argument::any())->willReturn($repo);
        $repo->findOneBy(Argument::any())->willReturn($translation);
        $translation->getTranslatable()->willReturn($page);
    }

    function its_getHomepage_that_should_return_page($page)
    {
        $this->getHomepage()->shouldReturn($page);
    }
}
