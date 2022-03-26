<?php
declare(strict_types=1);

namespace Gutocf\PageTitle\Controller\Component;

use Cake\Collection\CollectionInterface;
use Cake\Controller\Component;

/**
 * PageTitle component
 *
 * @property \Cake\Collection\CollectionInterface $titles
 */
class PageTitleComponent extends Component
{
    private CollectionInterface $titles;

    /**
     * @inheritDoc
     */
    protected $_defaultConfig = [
        'default' => null,
        'separator' => ' / ',
        'var' => 'title',
        'reverseOrder' => true,
    ];

    /**
     * @inheritDoc
     */
    public function initialize(array $config): void
    {
        $this->reset();
    }

    /**
     * @inheritDoc
     */
    public function beforeRender(): void
    {
        $var = $this->getConfig('var');
        $title = $this->getFormattedTitle();
        $this->getController()->set($var, $title);
    }

    /**
     * @param string ...$titles Titles to add
     * @return self
     */
    public function add(string ...$titles): self
    {
        $this->titles = $this->titles->append($titles);

        return $this;
    }

    /**
     * Reset titles and add new ones.
     *
     * @param string ...$titles Clear current titles and add new ones
     * @return self
     */
    public function clearAndAdd(string ...$titles): self
    {
        $this->reset();
        $this->add(...$titles);

        return $this;
    }

    /**
     * Resets the titles collection and adds the default title.
     *
     * @return self
     */
    public function reset(): self
    {
        $this->titles = collection([$this->getConfig('default')]);

        return $this;
    }

    /**
     * Returns the formatted title.
     *
     * @return string
     */
    public function getFormattedTitle(): string
    {
        $titles = $this->getConfig('reverseOrder') ?
            array_reverse($this->titles->toList()) :
            $this->titles->toList();

        return join($this->getConfig('separator'), $titles);
    }
}
