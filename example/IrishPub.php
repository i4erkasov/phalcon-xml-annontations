<?php

namespace ExamplePhalconXML;

/**
 * @XML\Document(
 *     "rootTag"="xml",
 *     "version"="1.0",
 *     "encoding"="UTF-8",
 * )
 * @XML\Tag("name"="IrishPub", "cdata"="Irish Pub")
 */
class IrishPub
{
    private string $name;

    private string $location;

    /**
     * @XML\Attribute("name"="OpeningTime")
     */
    private string $openingTime;

    /**
     * @XML\Attribute("name"="ClosingTime")
     */
    private string $closingTime;


    public function __construct(string $name, string $location, string $openingTime, string $closingTime)
    {
        $this->name = $name;
        $this->location = $location;
        $this->openingTime = $openingTime;
        $this->closingTime = $closingTime;
    }

    /**
     * @XML\Attribute("name"="Name")
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @XML\Attribute("name"="Address")
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    public function getOpeningTime(): string
    {
        return $this->openingTime;
    }

    public function getClosingTime(): string
    {
        return $this->closingTime;
    }

    /**
     * @XML\Tag("name"="BeerList")
     */
    public function getBeerList(): \Generator
    {
        yield new Beer("Guinness", "Stout", 4.2, "Ireland");
        yield new Beer("Smithwick's", "Red Ale", 4.5, "Ireland");
        yield new Beer("Harp Lager", "Lager", 4.5, "Ireland");
    }
}