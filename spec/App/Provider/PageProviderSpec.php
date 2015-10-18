<?php

namespace spec\App\Provider;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PageProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('App\Provider\PageProvider');
    }

    /**
     * @param \Doctrine\ORM\EntityManager                    $em
     * @param \Doctrine\ORM\EntityRepository                 $repo
     * @param \App\Entity\PageTranslation                    $translation
     * @param \App\Entity\Page                               $page
     * @param \Symfony\Component\HttpFoundation\RequestStack $requestStack
     * @param \Symfony\Component\HttpFoundation\Request      $request
     */
    public function let($em, $repo, $translation, $page, $requestStack, $request)
    {
        $requestStack->getCurrentRequest()->willReturn($request);
        $request->getLocale()->willReturn('en');

        $em->getRepository(Argument::any())->willReturn($repo);
        $repo->findOneBy(Argument::any())->willReturn($translation);
        $translation->getTranslatable()->willReturn($page);

        $this->beConstructedWith($em, $requestStack);
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
