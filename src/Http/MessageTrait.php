<?php

declare(strict_types=1);

namespace Guyon\Http;

use Psr\Http\Message\StreamInterface;

trait MessageTrait
{
    /**
     * @var string
     */
    private $protocolVersion;

    /**
     * @var array
     */
    private $headerNames = [];

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var StreamInterface
     */
    private $body;

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function withProtocolVersion($version)
    {
        $inst = clone $this;
        $inst->protocolVersion = $version;
        return $inst;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function hasHeader($name)
    {
        return isset($this->headers[$this->headerNames[strtolower($name)]]);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        return $this->headers[$this->headerNames[strtolower($name)]];
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaderLine($name)
    {
        return join(',', $this->getHeader($name));
    }

    /**
     * {@inheritdoc}
     */
    public function withHeader($name, $value)
    {
        $inst       = clone $this;
        $lowered    = strtolower($name);
        $normalized = $this->normalizeHeaderName($name);
        $rval       = is_array($value) ? $value : [$value];

        $inst->headerNames[$lowered] = $normalized;
        $inst->headers[$normalized]  = $rval;

        return $inst;
    }

    /**
     * {@inheritdoc}
     */
    public function withAddedHeader($name, $value)
    {
        $inst       = clone $this;
        $lowered    = strtolower($name);
        $normalized = $this->normalizeHeaderName($name);
        $rval       = is_array($value) ? $value : [$value];

        if (!$inst->hasHeader($name)) {
            $inst->headerNames[$lowered] = $normalized;
            $inst->headers[$normalized]  = $rval;
        } else {
            $inst->headers[$normalized] = array_merge(
                $inst->headers[$normalized],
                $rval
            );
        }

        return $inst;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutHeader($name)
    {
        $inst    = clone $this;
        $lowered = strtolower($name);

        if ($inst->hasHeader($name)) {
            unset($inst->headers[$inst->headerNames[$lowered]]);
            unset($inst->headerNames[$lowered]);
        }

        return $inst;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function withBody(StreamInterface $body)
    {
        $inst = clone $this;
        $inst->body = $body;
        return $inst;
    }

    /**
     * Normalize header name as provided in standard.
     *
     * @param string $name
     * @return string
     */
    private function normalizeHeaderName($name)
    {
        // content-type: application/json
        $splitted = array_map(
            function ($part) {
                return ucfirst(strtolower($part));
            },
            explode('-', $name)
        );

        return join('-', $splitted);
    }
}
