<?php

namespace I4\Phalcon\XML\Annotations;

class Document extends AbstractTag
{
    private string $version;

    private string $encoding;

    public const ANNOTATION = 'XML\Document';

    /**
     * @param string $rootTag
     * @param string $version
     * @param string $encoding
     */
    public function __construct(
        string $rootTag,
        string $version = '1.0',
        string $encoding = 'UTF-8',
        ?array $tags = [],
        ?array $attributes = []
    ) {
        $this->version = $version;
        $this->encoding = $encoding;

        $this->setName($rootTag);
        $this->addTags($tags ?? []);
        $this->addAttributes($attributes ?? []);
    }

    /**
     * @return string
     */
    public function getRootTag(): string
    {
        return $this->getName();
    }

    /**
     * @param string $rootTag
     */
    public function setRootTag(string $rootTag): Document
    {
        $this->setName($rootTag);

        return $this;
    }

    /**
     * @param string $version
     * @return Document
     */
    public function setVersion(string $version): Document
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @param string $encoding
     */
    public function setEncoding(string $encoding): Document
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }
}
