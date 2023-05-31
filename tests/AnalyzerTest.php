<?php

namespace TestPhalconXML;

use I4\Phalcon\XML\Analyzer;
use I4\Phalcon\XML\Annotations\Attribute;
use I4\Phalcon\XML\Annotations\Document;
use I4\Phalcon\XML\Interfaces\AnalyzerInterface;
use PHPUnit\Framework\TestCase;
use Phalcon\Annotations\Adapter\Memory;
use TestPhalconXML\Data\MyXmlObject;

final class AnalyzerTest extends TestCase
{
    protected AnalyzerInterface $analyzer;

    public function setUp(): void
    {
        $this->analyzer = new Analyzer(new Memory());
    }

    public function testAnalyzerResultNull()
    {
        $res = $this->analyzer->analyze(new \stdClass());

        $this->assertNull($res);
    }

    public function testAnalyzerResultDocument()
    {
        $document = $this->analyzer->analyze(new MyXmlObject());

        $this->assertInstanceOf(Document::class, $document);
        $this->assertStringContainsString($document->getRootTag(), 'XML');

        foreach ($res->getTags() as $tag) {
            $this->assertInstanceOf(Tag::class, $res);
            $this->assertStringContainsString($tag->getName(), 'Person');

            foreach ($tag->getAttributes() as $attribute) {
                $this->assertInstanceOf(Attribute::class, $attribute);

                $this->assertObjectEquals($attribute, new Attribute($attribute->getName(), $attribute->getValue()));
            }
        }
    }
}