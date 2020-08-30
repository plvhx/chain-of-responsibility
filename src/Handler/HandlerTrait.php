<?php

declare(strict_types=1);

namespace Guyon\Handler;

trait HandlerTrait
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     * @return void
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
}
