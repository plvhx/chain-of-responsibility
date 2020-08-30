<?php

declare(strict_types=1);

namespace Guyon;

final class ChainHandlerBuilder
{
    /**
     * @var array
     */
    private $handlers = [];

    /**
     * Add handler context.
     *
     * @param RequestHandlerInterface $handler
     * @return static
     */
    public function addHandler(RequestHandlerInterface $handler)
    {
        $this->handlers[] = $handler;
        return $this;
    }

    /**
     * Get all handlers.
     *
     * @return array
     */
    public function getHandlers()
    {
        return $this->handlers;
    }

    /**
     * Build all contexts.
     *
     * @return RequestHandlerInterface
     */
    public function build()
    {
        $handlers = $this->getHandlers();

        if (empty($handlers)) {
            return null;
        }

        // <handler-1> -> <handler-2> -> <handler-n>
        for ($i = 1; $i < sizeof($handlers); $i++) {
            $handlers[$i - 1]->setSuccessor($handlers[$i]);
        }

        return $handlers[0];
    }
}
