<?php

declare(strict_types=1);

namespace Guyon\Handler;

use Guyon\AbstractRequestHandler;
use Psr\Http\Message\RequestInterface;

class AddBarHeader extends AbstractRequestHandler
{
    use HandlerTrait;

    /**
     * {@inheritdoc}
     */
    public function process(RequestInterface $request)
    {
        return $request->withHeader('X-Bar', $this->value);
    }
}
