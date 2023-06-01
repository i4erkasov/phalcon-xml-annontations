# Phalcon XML Annotations

[![Latest Stable Version](https://poser.pugx.org/i4erkasov/phalcon-xml-annotations/v)](https://packagist.org/packages/i4erkasov/phalcon-xml-annotations)
[![Total Downloads](https://poser.pugx.org/i4erkasov/phalcon-xml-annotations/downloads)](https://packagist.org/packages/i4erkasov/phalcon-xml-annotations)
[![License](https://poser.pugx.org/i4erkasov/phalcon-xml-annotations/license)](https://packagist.org/packages/i4erkasov/phalcon-xml-annotations)

Phalcon XML Annotations is a library that allows you to convert PHP objects into XML files. It provides annotations to define the structure and parameters of XML files based on PHP objects.

## Installation

You can install the Phalcon XML Annotations library using Composer. Simply run the following command in your project:

```bash
composer require i4erkasov/phalcon-xml-annotations
```

## Documentation

⚠️ *Documentation is under development*: This library is actively being developed, and documentation is currently being created. We apologize for any inconvenience. Please refer to the source code and examples for usage instructions and implementation details. Thank you for your understanding.

## Usage Example

See the `example` directory for context.
#### Code:
```php
<?php

use ExamplePhalconXML\IrishPub;
use I4\Phalcon\XML\Analyzer;
use I4\Phalcon\XML\XmlAnnotations;
use Phalcon\Annotations\Adapter\Memory;

$annotations = new XmlAnnotations(
    new Analyzer(new Memory())
);

$xml = $annotations->parse(
    new IrishPub(
        'The Shamrock Pub',
        'Dublin, Ireland',
        '10:00 AM',
        '2:00 AM'
    )
);

$xml->setExtraAttributes([
    'Beer' => [
        'Date' => (new DateTime('now'))->format('Y-m-d'),
    ]
]);

echo $xml->getString(); // Returns the XML as a string

echo $xml->save('/tmp/file.xml'); // Saves the generated XML to a file
```
#### Result:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<XML>
  <IrishPub Name="The Shamrock Pub" Address="Dublin, Irelan" OpeningTime="10:00 AM" ClosingTime="2:00 AM">
      <![CDATA[Irish Pub]]>
    <BeerList>
      <Beer Brand="Guinness" Type="Stout" ABV="4.2" Country="Ireland"/>
      <Beer Brand="Smithwick's" Type="Red Ale" ABV="4.5" Country="Ireland"/>
      <Beer Brand="Harp Lager" Type="Lager" ABV="4.5" Country="Ireland"/>
    </BeerList>
  </IrishPub>
</XML>
```

## Contributions

You can contribute to the development of this library by creating issues, suggesting new features, and submitting pull requests to the GitHub repository.

## License

Phalcon XML Annotations is released under the [MIT License](https://opensource.org/licenses/MIT).