<?php

namespace spec\Bootstrapper;

use Mockery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NavigationSpec extends ObjectBehavior
{

    function let()
    {
        $mock = Mockery::mock('Illuminate\Routing\UrlGenerator');
        $mock->shouldReceive('current')->andReturn('link');

        $this->beConstructedWith($mock);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Bootstrapper\Navigation');
        $this->shouldHaveType('Bootstrapper\RenderedObject');
    }

    function it_can_be_rendered()
    {
        $this->render()->shouldBe("<ul class='nav nav-tabs'></ul>");
    }

    function it_can_be_given_attributes()
    {
        $this->withAttributes(['data-foo' => 'bar'])->render()->shouldBe(
            "<ul class='nav nav-tabs' data-foo='bar'></ul>"
        );
    }

    function it_can_be_made_into_pills()
    {
        $this->pills()->render()->shouldBe("<ul class='nav nav-pills'></ul>");
    }

    function it_can_be_given_contents()
    {
        $this->links(
            [
                [
                    'link' => 'foo',
                    'title' => 'bar',
                ],
                [
                    'link' => 'goo',
                    'title' => 'gar',
                ],
            ]
        )->render()->shouldBe(
            "<ul class='nav nav-tabs'><li><a href='foo'>bar</a></li><li><a href='goo'>gar</a></li></ul>"
        );
    }

    function it_allows_you_to_use_shortcut_methods()
    {
        $types = ['pills', 'tabs'];

        foreach ($types as $type) {
            $this->$type(
                [
                    [
                        'link' => 'foo',
                        'title' => 'bar',
                    ],
                    [
                        'link' => 'goo',
                        'title' => 'gar',
                    ],
                ]
            )->render()->shouldBe(
                "<ul class='nav nav-{$type}'><li><a href='foo'>bar</a></li><li><a href='goo'>gar</a></li></ul>"
            );
        }

    }

    function it_provides_autorouting()
    {
        $this->links(
            [
                [
                    'link' => 'link',
                    'title' => 'bar',
                ],
                [
                    'link' => 'goo',
                    'title' => 'gar',
                ],
            ]
        )->render()->shouldBe(
            "<ul class='nav nav-tabs'><li class='active'><a href='link'>bar</a></li><li><a href='goo'>gar</a></li></ul>"
        );
    }

    function it_allows_you_to_turn_off_autorouting()
    {
        $this->autoroute(false)->links(
            [
                [
                    'link' => 'link',
                    'title' => 'bar',
                ],
                [
                    'link' => 'goo',
                    'title' => 'gar',
                ],
            ]
        )->render()->shouldBe(
            "<ul class='nav nav-tabs'><li><a href='link'>bar</a></li><li><a href='goo'>gar</a></li></ul>"
        );
    }
}
