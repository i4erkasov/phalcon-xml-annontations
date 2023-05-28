<?php

namespace I4\Phalcon\XML\Annotations;

abstract class AbstractTag
{
    private string $name;

    private array $attributes = [];

    private array $tags = [];

    /**
     * @var callable $funcIterableTag
     */
    private  $funcIterableTag = null;

    /**
     * @var callable $funcIterableAttribute
     */
    private  $funcIterableAttribute = null;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array|null $tags
     * @return $this
     */
    public function setTags(?array $tags): self
    {
        $this->tags = $tags ?? [];

        return $this;
    }

    /**
     * @param callable|null $callback
     * @return $this
     */
    public function setFuncIterableAttribute(?callable $callback): self
    {
        $this->funcIterableAttribute = $callback;

        return $this;
    }

    /**
     * @param callable|null $callback
     * @return $this
     */
    public function setFuncIterableTag(?callable $callback): self
    {
        $this->funcIterableTag = $callback;

        return $this;
    }

    /**
     * @param array|null $tags
     * @return $this
     */
    public function addTags(?array $tags): self
    {
        $this->tags = array_merge($this->tags, $tags ?? []);

        return $this;
    }

    /**
     * @param Tag $tag
     * @return $this
     */
    public function addTag(Tag $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @return \Generator
     */
    public function getTags(): \Generator
    {
        yield from $this->tags;

        if ($this->funcIterableTag !== null) {
            foreach (($this->funcIterableTag)() as $item) {
                if ($item instanceof \Generator) {
                    yield from $item;
                }

                if ($item instanceof Tag) {
                    yield $item;
                }
            }
        }
    }

    /**
     * @param Attribute $attribute
     * @return $this
     */
    public function addAttribute(Attribute $attribute): self
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function addAttributes(array $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    /**
     * @return \Generator
     */
    public function getAttributes(): \Generator
    {
        yield from $this->attributes;

        if ($this->funcIterableAttribute !== null) {
            foreach (($this->funcIterableAttribute)() as $item) {
                if ($item instanceof \Generator) {
                    yield from $item;
                }

                if ($item instanceof Attribute) {
                    yield $item;
                }
            }
        }
    }
}