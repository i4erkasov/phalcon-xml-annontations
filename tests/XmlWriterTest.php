<?php

namespace TestPhalconXML;

use I4\Phalcon\XML\Annotations\Attribute;
use I4\Phalcon\XML\Annotations\Document;
use I4\Phalcon\XML\Annotations\Tag;
use I4\Phalcon\XML\XmlWriter;
use PHPUnit\Framework\TestCase;

final class XmlWriterTest extends TestCase
{
    public function testGetXmlReturnsCorrectXmlString()
    {
        $writer = new XmlWriter();
        $document = new Document('1.0', 'UTF-8', 'root');
        $tag1 = new Tag('tag1');
        $tag2 = new Tag('tag2');
        $attribute1 = new Attribute('attr1', 'value1');
        $attribute2 = new Attribute('attr2', 'value2');

        $tag1->addAttribute($attribute1);
        $tag2->addAttribute($attribute2);
        $tag1->addTag($tag2);
        $document->addTag($tag1);

        $expectedXml = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<root><tag1 attr1="value1"><tag2 attr2="value2">'
            .'</tag2></tag1></root>';

        $this->assertEquals($expectedXml, $writer->getXml($document));
    }

    public function testSaveXmlReturnsCorrectNumberOfBytesWritten()
    {
        $writer = new XmlWriter();
        $document = new Document('1.0', 'UTF-8', 'root');
        $tag = new Tag('tag');

        $document->addTag($tag);

        $filename = 'test.xml';
        $bytesWritten = $writer->saveXml($document, $filename);

        $this->assertFileExists($filename);
        $this->assertGreaterThan(0, $bytesWritten);

        unlink($filename);
    }
}