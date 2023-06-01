## Usage Example

Here's an example of how to use the library with the `IrishPub` class:

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

### Dependency: Analyzer and Adapter
The `Analyzer` class has a dependency on the `Adapter` class, which is an implementation of the `AdapterInterface` defined in the Phalcon library. The `AdapterInterface` serves as the base interface for different adapters used in Phalcon Annotations. In the example, the `Memory` adapter is used, which stores annotations in memory.

For more detailed information about `AdapterInterface` and other available adapters in Phalcon Annotations, please refer to the official Phalcon documentation at [https://docs.phalcon.io/4.0/en/api/phalcon_annotations](https://docs.phalcon.io/4.0/en/api/phalcon_annotations).

In this example, we create an instance of the `XmlAnnotations` class and pass it a `Memory` adapter for annotations. Then, we use the `parse()` method to parse the `IrishPub` class and generate XML based on the annotations.

We can also set extra attributes for specific XML elements using the `setExtraAttributes()` method. In this case, we add an extra attribute called "Date" to each "Beer" element with the current date.

Finally, we can retrieve the XML as a string using the `getString()` method or save it to a file using the `save()` method.