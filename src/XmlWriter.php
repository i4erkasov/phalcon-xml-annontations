<?php

namespace I4\Phalcon\XML;

use I4\Phalcon\XML\Annotations\Attribute;
use I4\Phalcon\XML\Annotations\Document;
use I4\Phalcon\XML\Annotations\Tag;
use I4\Phalcon\XML\Interfaces\XmlWriterInterface;

class XmlWriter extends \XMLWriter implements XmlWriterInterface
{
    private array $extraAttributes = [];

    /**
     * @param Document $document
     *
     * @return string
     */
    public function getXml(Document $document): string
    {
        $this->openMemory();
        $this->generate($document);

        return $this->outputMemory();
    }

    /**
     * @param Document $document
     * @param string   $name
     *
     * @return int
     */
    public function saveXml(Document $document, string $name): int
    {
        $this->openUri($name);
        $this->generate($document);

        return $this->flush();
    }

    /**
     * @param array<string, array> $attributes
     *
     * @return XmlWriter
     */
    public function addExtraAttributes(array $attributes = []): self
    {
        foreach ($attributes as $tag => $attr) {
            if (!is_array($attr)) {
                throw new \RuntimeException(
                    "Invalid input parameters.\\n Format example ['tagName => ['attributeName' => 'attributeValue']]"
                );
            }

            foreach ($attr as $k => $v) {
                if (is_array($v)) {
                    throw new \RuntimeException(
                        "Invalid input parameters.\\n Format example ['tagName => ['attributeName' => 'attributeValue']]"
                    );
                }

                $this->extraAttributes[$tag][] = new Attribute($k, $v);
            }
        }

        return $this;
    }

    private function generate(Document $document)
    {
        $this->startDocument($document->getVersion(), $document->getEncoding());
        $this->writeDocumentTag($document);
        $this->endDocument();
    }

    /**
     * @param Document $document
     */
    private function writeDocumentTag(Document $document)
    {
        $this->startElement($document->getRootTag());
        $this->writeAttributes($document->getAttributes());

        foreach ($document->getTags() as $tag) {
            $this->writeTag($tag);
        }

        $this->endElement();
    }

    /**
     * @param Tag $tag
     */
    private function writeTag(Tag &$tag): void
    {
        $this->startElement($tag->getName());

        if (isset($this->extraAttributes[$tag->getName()])) {
            $tag->addAttributes($this->extraAttributes[$tag->getName()]);
        }

        $this->writeAttributes($tag->getAttributes());

        if ($tag->getContent()) {
            $this->text($tag->getContent());
        }

        if ($tag->getComment()) {
            $this->writeComment($tag->getComment());
            $this->endComment();
        }

        if ($tag->getCdata()) {
            $this->writeCdata($tag->getCdata());
            $this->endCdata();
        }

        foreach ($tag->getTags() as $innerTag) {
            $this->writeTag($innerTag);
        }

        $this->endElement();
    }

    /**
     * @param \Iterator $attributes
     */
    private function writeAttributes(\Iterator $attributes): void
    {
        foreach ($attributes as $attribute) {
            if ($attribute instanceof Attribute) {
                $this->writeAttribute($attribute->getName(), $attribute->getValue());
            }
        }
    }
}