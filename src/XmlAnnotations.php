<?php

namespace I4\Phalcon\XML;

use I4\Phalcon\XML\Annotations\Document;
use I4\Phalcon\XML\Interfaces\XmlWriterInterface;

class XmlAnnotations
{
    /**
     * @var Document|null $document
     */
    private ?Document $document = null;

    /**
     * @var XMLWriterWrapper $writer
     */
    private XmlWriterInterface $writer;

    private Analyzer $analyzer;

    /**
     * @param Analyzer $analyzer
     * @param XmlWriterInterface|null $writer
     */
    public function __construct(Analyzer $analyzer, XmlWriterInterface $writer = null)
    {
        $this->writer = $writer ?? (new XmlWriter());
        $this->analyzer = $analyzer;
    }

    /**
     * @throws \ReflectionException
     */
    public function parse(object $input): self
    {
        $this->document = $this->analyzer->analyze($input);

        return $this;
    }

    /**
     * @param array<string, array> $attributes
     *
     * @return XmlAnnotations
     */
    public function setExtraAttributes(array $attributes): self
    {
        $this->writer->addExtraAttributes($attributes);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getString(): ?string
    {
        if (!$this->document) {
            return null;
        }

        return $this->writer->getXml($this->document);
    }

    /**
     * @param string $name
     * @return int|null
     */
    public function save(string $name): ?int
    {
        if (!file_exists(dirname($name))) {
            mkdir(dirname($name), 0775, true);
        }

        if (!$this->document) {
            return null;
        }

        return $this->writer->saveXml($this->document, $name);
    }
}