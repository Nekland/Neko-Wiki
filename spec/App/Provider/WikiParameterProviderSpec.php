<?php

namespace spec\App\Provider;


use PhpSpec\ObjectBehavior;

class WikiParameterProviderSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['foo' => 'bar']);
    }

    public function it_should_be_able_to_return_foo()
    {
        $this->foo->shouldBe('bar');
    }
}
