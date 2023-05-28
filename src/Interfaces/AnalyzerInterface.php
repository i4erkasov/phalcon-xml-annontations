<?php

namespace I4\Phalcon\XML\Interfaces;

use Phalcon\Annotations\Adapter\AdapterInterface;
use I4\Phalcon\XML\Annotations\Document;

interface AnalyzerInterface
{
    /**
     * @param AdapterInterface $reader
     */
    public function __construct(AdapterInterface $reader);

    /**
     * @param object $input
     * @return Document|null
     * @throws \ReflectionException
     */
    public function analyze(object $input): ?Document;
}