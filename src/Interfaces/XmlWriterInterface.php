<?php

namespace I4\Phalcon\XML\Interfaces;

use I4\Phalcon\XML\Annotations\Document;

interface XmlWriterInterface
{
    /**
     * @param Document $document
     * @return string
     */
    public function getXml(Document $document): string;

    /**
     * @param Document $document
     * @param string $name
     * @return int
     */
    public function saveXml(Document $document, string $name): int;

    /**
     * @param array<string, array> $attributes
     * @return XmlWriterInterface
     */
    public function addExtraAttributes(array $attributes = []): XmlWriterInterface;
}