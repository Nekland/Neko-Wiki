<?php

namespace spec\App\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Provider\PageProvider');
    }

    /**
     * @param \Doctrine\ORM\EntityManager    $em
     * @param \Doctrine\ORM\EntityRepository $repo
     * @param \App\Entity\Page               $page
     */
    function let($em, $repo, $page)
    {
        $this->beConstructedWith($em);
        $em->getRepository(Argument::any())->willReturn($repo);
        $repo->findOneBy(Argument::any())->willReturn($page);
    }

    function its_getHomepage_that_should_return_page($page)
    {
        $this->getHomepage()->shouldReturn($page);
    }
}
