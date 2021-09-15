<?php

declare(strict_types=1);

namespace Gutocf\PageTitle\Controller\Component;

use Cake\Controller\Component;
use Cake\Collection\Collection;

/**
 * @method \App\Controller\AppController getController()
 */
class PageTitleComponent extends Component
{
    private Collection $titles;

    protected $_defaultConfig = [
        'default' => null,
        'separator' => ' / ',
        'var' => 'title',
    ];

    public function initialize(array $config): void
    {
        $this->reset();
    }

    public function beforeRender(): void
    {
        $this->getController()->set($this->getConfig('var'), $this->formatTitle());
    }

    public function add(...$titles): void
    {
        $this->titles = $this->titles->append($titles);
    }

    public function clearAndAdd(...$titles): void
    {
        $this->reset();
        $this->add(...$titles);
    }

    public function reset(): void
    {
        $this->titles = new Collection([]);
    }

    private function formatTitle(): string
    {
        $titles = array_reverse($this->titles
            ->prependItem($this->getConfig('default'))
            ->toList());

        return join($this->getConfig('separator'), $titles);
    }
}
