<?php

namespace Gutocf\PageTitle\Test\TestCase\Controller\Component;

use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Cake\Controller\Controller;
use Gutocf\PageTitle\Controller\Component\PageTitleComponent;

/**
 * @property \App\Controller\Component\PageTitleComponent $component
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
        $this->PageTitle = new PageTitleComponent($this->Controller->components());
        $this->PageTitle->setConfig('default', 'default');
    }

    public function testAdd()
    {
        $this->PageTitle->add('t1');
        $this->PageTitle->beforeRender();
        $this->assertEquals('t1 / default', $this->Controller->viewBuilder()->getVar('title'));
    }

    public function testAddMultiple()
    {
        $this->PageTitle->add('t1', 't2');
        $this->PageTitle->add('t3');
        $this->PageTitle->beforeRender();
        $this->assertEquals('t3 / t2 / t1 / default', $this->Controller->viewBuilder()->getVar('title'));
    }

    public function testChangeSeparator()
    {
        $this->PageTitle->setConfig('separator', ' - ');
        $this->PageTitle->add('t1', 't2');
        $this->PageTitle->beforeRender();
        $this->assertEquals('t2 - t1 - default', $this->Controller->viewBuilder()->getVar('title'));
    }

    public function testClearAndAdd()
    {
        $this->PageTitle->add('t1');
        $this->PageTitle->clearAndAdd('t2');
        $this->PageTitle->beforeRender();
        $this->assertEquals('t2 / default', $this->Controller->viewBuilder()->getVar('title'));
    }

    public function testReset()
    {
        $this->PageTitle->add('t1');
        $this->PageTitle->beforeRender();
        $this->assertEquals('t1 / default', $this->Controller->viewBuilder()->getVar('title'));
        $this->PageTitle->reset();
        $this->PageTitle->add('t2');
        $this->PageTitle->beforeRender();
        $this->assertEquals('t2 / default', $this->Controller->viewBuilder()->getVar('title'));
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->PageTitle, $this->Controller);
    }
}
