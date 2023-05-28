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

```php
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
    public string $name;

    /**
     * @XML\Tag("name"="age")
     */
    public int $age;
}
```

## Contributions

You can contribute to the development of this library by creating issues, suggesting new features, and submitting pull requests to the GitHub repository.

## License

Phalcon XML Annotations is released under the [MIT License](https://opensource.org/licenses/MIT).