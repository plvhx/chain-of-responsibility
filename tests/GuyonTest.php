<?php

declare(strict_types=1);

namespace Guyon\Tests;

use PHPUnit\Framework\TestCase;
use Guyon\ChainHandlerBuilder;
use Guyon\Handler\AddFooHeader;
use Guyon\Handler\AddBarHeader;
use Guyon\Handler\AddContentLengthHeader;
use Guyon\Http\Request;

class GuyonTest extends TestCase
{
    /**
     * @var Psr\Http\Message\RequestInterface
     */
    private $request;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->request = new Request();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
    }

    public function testCanDynamicallyInjectHeaders()
    {
        $handler = (new ChainHandlerBuilder())
            ->addHandler(new AddFooHeader('this is a foo'))
            ->addHandler(new AddBarHeader('this is a bar'))
            ->addHandler(new AddContentLengthHeader(1001))
            ->build();
        $request = $handler($this->request);

        $this->assertTrue($request->hasHeader('X-Foo'));
        $this->assertTrue($request->hasHeader('X-Bar'));
        $this->assertTrue($request->hasHeader('Content-Length'));
    }
}
