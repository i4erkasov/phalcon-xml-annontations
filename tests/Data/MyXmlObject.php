<?php

namespace TestPhalconXML\Data;

/**
 * @XML\Document(
 *     "rootTag"="XML",
 *     "version"="1.0",
 *     "encoding"="UTF-8",
 * )
 * @XML\Tag("name"="Person")
 */
class MyXmlObject
{
    /**
     * @XML\Attribute("name"="last_name")
     */
    public string $name = 'test';

    /**
     * @XML\Attribute("name"="age")
     */
    public int $age = 18;
}