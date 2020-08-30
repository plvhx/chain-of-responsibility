<?php

declare(strict_types=1);

namespace Guyon;

use Psr\Http\Message\RequestInterface;

interface RequestHandlerInterface
{
	/**
	 * Process request object in local context and with
	 * successor context.
	 *
	 * @param RequestInterface $request
	 * @return RequestInterface
	 */
    public function handle(RequestInterface $request);

    /**
     * Process request object in local context.
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function process(RequestInterface $request);

    /**
     * Set successor context.
     *
     * @param RequestHandlerInterface $successor
     * @return void
     */
    public function setSuccessor(RequestHandlerInterface $successor);

    /**
     * Get successor context.
     *
     * @return RequestHandlerInterface
     */
    public function getSuccessor();

    /**
     * Call handle() method.
     *
     * @param RequestInterface $request
     * @return RequestInterface
     */
    public function __invoke(RequestInterface $request);
}
