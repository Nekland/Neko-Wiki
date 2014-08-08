<?php

namespace spec\App\Provider;

use App\Entity\Page;
use App\Entity\PageTranslation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class PageProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
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

    public function its_getHomepage_that_should_return_page($page)
    {
        $this->getHomepage()->shouldReturn($page);
    }

    public function it_should_create_page_object_with_title()
    {
        $this->createPage('title of the page')->shouldHaveType('App\Entity\Page');
    }
}
