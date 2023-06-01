<?php

namespace ExamplePhalconXML;

/**
 * @XML\Tag("name"="Beer")
 */
class Beer
{
    private string $brand;
    private string $type;
    private string $abv;
    private string $country;

    public function __construct($brand, $type, $abv, $country)
    {
        $this->brand = $brand;
        $this->type = $type;
        $this->abv = $abv;
        $this->country = $country;
    }

    /**
     * @XML\Attribute("name"="Brand")
     *
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @XML\Attribute("name"="Type")
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @XML\Attribute("name"="ABV")
     *
     * @return string
     */
    public function getAbv(): string
    {
        return $this->abv;
    }

    /**
     * @XML\Attribute("name"="Country")
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }
}