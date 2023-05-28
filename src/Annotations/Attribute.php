<?php

namespace I4\Phalcon\XML\Annotations;

class Attribute extends AbstractAttribute
{
    public const ANNOTATION = 'XML\Attribute';

    public function __construct(string $name, $value = null)
    {
        $this->setName($name);

        if($value) {
            $this->setValue($value);
        }
    }
}