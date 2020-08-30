<?php

declare(strict_types=1);

namespace Guyon;

use Psr\Http\Message\RequestInterface;

abstract class AbstractRequestHandler implements RequestHandlerInterface
{
    /**
     * @var RequestHandlerInterface|null
     */
    private $successor = null;

    /**
     * {@inheritdoc}
     */
    public function handle(RequestInterface $request)
    {
        $res = $this->process($request);

        if (null !== $this->getSuccessor()) {
            $res = $this->getSuccessor()->handle($res);
        }

        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function setSuccessor(RequestHandlerInterface $successor)
    {
        $this->successor = $successor;
    }

    /**
     * {@inheritdoc}
     */
    public function getSuccessor()
    {
        return $this->successor;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(RequestInterface $request)
    {
        return $this->handle($request);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function process(RequestInterface $request);
}
