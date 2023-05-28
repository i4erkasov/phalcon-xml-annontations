<?php

namespace I4\Phalcon\XML\Annotations;

class Tag extends AbstractTag
{
    private ?string $content;

    private ?string $comment;

    private ?string $cdata;

    public const ANNOTATION = 'XML\Tag';

    public function __construct(
        string $name,
        ?string $content = null,
        ?string $comment = null,
        ?string $cdata = null,
        ?array $tags = [],
        ?array $attributes = []
    ) {
        $this->content = $content;
        $this->comment = $comment;
        $this->cdata = $cdata;

        $this->setName($name);
        $this->addTags($tags ?? []);
        $this->addAttributes($attributes ?? []);
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): Tag
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     */
    public function setComment(?string $comment): Tag
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCdata(): ?string
    {
        return $this->cdata;
    }

    /**
     * @param string|null $cdata
     * @return Tag
     */
    public function setCdata(?string $cdata): Tag
    {
        $this->cdata = $cdata;
        return $this;
    }
}