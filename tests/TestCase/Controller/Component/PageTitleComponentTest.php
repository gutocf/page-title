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
    protected $PageTitle;
    protected $Controller;

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

    public function testAdd()
    {
        $this->PageTitle->add('t1');
        $this->assertEquals('t1 / default', $this->PageTitle->getFormattedTitle());
    }

    public function testAddMultiple()
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

    public function testChangeSeparator()
    {
        $this->PageTitle->setConfig('separator', ' - ');
        $actual = $this->PageTitle
            ->add('t1', 't2')
            ->getFormattedTitle();

        $this->assertEquals('t2 - t1 - default', $actual);
    }

    public function testClearAndAdd()
    {
        $this->PageTitle->add('t1');
        $actual = $this->PageTitle
            ->clearAndAdd('t2')
            ->getFormattedTitle();

        $this->assertEquals('t2 / default', $actual);
    }

    public function testReset()
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

    public function testBeforeRender()
    {
        $this->PageTitle
            ->add('t1')
            ->beforeRender();

        $actual = $this->Controller->viewBuilder()->getVar('title');

        $this->assertEquals('t1 / default', $actual);
    }

    public function testReverseOrder()
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

    public function testChangeVar()
    {
        $this->PageTitle->setConfig('var', 'my_title');
        $this->PageTitle
            ->add('t1')
            ->beforeRender();

        $actual = $this->Controller->viewBuilder()->getVar('my_title');

        $this->assertEquals('t1 / default', $actual);
    }

    public function testIntegrationBeforeRender()
    {
        $Controller = new Controller(new ServerRequest(), new Response());
        $Controller->loadComponent('Gutocf/PageTitle.PageTitle', ['default' => 'default']);
        $Controller->PageTitle->add('t1');
        $Controller->getEventManager()->dispatch(new Event('Controller.beforeRender', $Controller));
        $this->assertEquals('t1 / default', $Controller->viewBuilder()->getVar('title'));
    }
}
