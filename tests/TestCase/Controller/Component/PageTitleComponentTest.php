<?php

namespace Gutocf\PageTitle\Test\TestCase\Controller\Component;

use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Gutocf\PageTitle\Controller\Component\PageTitleComponent;

/**
 * @property \Gutocf\PageTitle\Controller\Component\PageTitleComponent $PageTitle
 * @property \Cake\Controller\Controller $Controller
 */
class PageTitleComponentTest extends TestCase
{
    protected PageTitleComponent $PageTitle;
    protected Controller $Controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->Controller = new Controller(new ServerRequest(), new Response());
        $this->PageTitle = new PageTitleComponent($this->Controller->components(), ['default' => 'default']);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->PageTitle, $this->Controller);
    }

    public function testAdd(): void
    {
        $this->PageTitle->add('t1');
        $this->assertEquals('t1 / default', $this->PageTitle->getFormattedTitle());
    }

    public function testAddMultiple(): void
    {
        $actual = $this->PageTitle
            ->add('t1', 't2')
            ->add('t3')
            ->getFormattedTitle();

        $this->assertEquals('t3 / t2 / t1 / default', $actual);

        $actual = $this->PageTitle
            ->reset()
            ->add('t1')
            ->add('t2', 't3')
            ->getFormattedTitle();

        $this->assertEquals('t3 / t2 / t1 / default', $actual);
    }

    public function testChangeSeparator(): void
    {
        $this->PageTitle->setConfig('separator', ' - ');
        $actual = $this->PageTitle
            ->add('t1', 't2')
            ->getFormattedTitle();

        $this->assertEquals('t2 - t1 - default', $actual);
    }

    public function testClearAndAdd(): void
    {
        $this->PageTitle->add('t1');
        $actual = $this->PageTitle
            ->clearAndAdd('t2')
            ->getFormattedTitle();

        $this->assertEquals('t2 / default', $actual);
    }

    public function testReset(): void
    {
        $actual = $this->PageTitle
            ->add('t1')
            ->getFormattedTitle();

        $this->assertEquals('t1 / default', $actual);

        $actual = $this->PageTitle
            ->reset()
            ->add('t2')
            ->getFormattedTitle();

        $this->assertEquals('t2 / default', $actual);
    }

    public function testBeforeRender(): void
    {
        $this->PageTitle
            ->add('t1')
            ->beforeRender();

        $actual = $this->Controller->viewBuilder()->getVar('title');

        $this->assertEquals('t1 / default', $actual);
    }

    public function testReverseOrder(): void
    {
        $actual = $this->PageTitle
            ->add('t1')
            ->add('t2', 't3')
            ->getFormattedTitle();

        $this->assertEquals('t3 / t2 / t1 / default', $actual);

        $this->PageTitle->setConfig('reverseOrder', false);
        $actual = $this->PageTitle->getFormattedTitle();

        $this->assertEquals('default / t1 / t2 / t3', $actual);
    }

    public function testChangeVar(): void
    {
        $this->PageTitle->setConfig('var', 'my_title');
        $this->PageTitle
            ->add('t1')
            ->beforeRender();

        $actual = $this->Controller->viewBuilder()->getVar('my_title');

        $this->assertEquals('t1 / default', $actual);
    }

    public function testIntegrationBeforeRender(): void
    {
        $Controller = new Controller(new ServerRequest(), new Response());
        $Controller->loadComponent('Gutocf/PageTitle.PageTitle', ['default' => 'default']);
        /** @var \Gutocf\PageTitle\Controller\Component\PageTitleComponent $PageTitle */
        $PageTitle = $Controller->components()->get('PageTitle');
        $PageTitle->add('t1');
        $Controller->getEventManager()->dispatch(new Event('Controller.beforeRender', $Controller));
        $this->assertEquals('t1 / default', $Controller->viewBuilder()->getVar('title'));
    }
}
