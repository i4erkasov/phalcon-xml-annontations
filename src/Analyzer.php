<?php

namespace I4\Phalcon\XML;

use I4\Phalcon\XML\Annotations\Attribute;
use I4\Phalcon\XML\Annotations\Document;
use I4\Phalcon\XML\Annotations\Tag;
use I4\Phalcon\XML\Interfaces\AnalyzerInterface;
use Phalcon\Annotations\Adapter\AdapterInterface;
use Phalcon\Annotations\Annotation;
use Phalcon\Annotations\Reflection;

class Analyzer implements AnalyzerInterface
{
    /** @var \SplObjectStorage $storage */
    private \SplObjectStorage $storage;

    /** @var AdapterInterface $reader */
    private AdapterInterface $reader;

    private static array $instances = [];

    /**
     * @param AdapterInterface $reader
     */
    public function __construct(AdapterInterface $reader)
    {
        $this->reader = $reader;
        $this->storage = new \SplObjectStorage();
    }

    /**
     * @var array|string[]
     */
    private static array $annotations = [
        Document::ANNOTATION  => Document::class,
        Tag::ANNOTATION       => Tag::class,
        Attribute::ANNOTATION => Attribute::class,
    ];

    /**
     * @throws \ReflectionException
     */
    private static function getReflectionClass(string $name): ?\ReflectionClass
    {
        if (!isset(self::$annotations[$name])) {
            return null;
        }

        if (!isset(self::$instances[$name])) {
            self::$instances[$name] = new \ReflectionClass(self::$annotations[$name]);
        }

        return self::$instances[$name];
    }

    /**
     * @param object $object
     * @return Reflection
     */
    private function getReflector(object $object): Reflection
    {
        if (!$this->storage->contains($object)) {
            $this->storage[$object] = $this->reader->get(get_class($object));
        }

        return $this->storage[$object];
    }

    /**
     * @param object $input
     * @return Document|null
     * @throws \ReflectionException
     */
    public function analyze(object $input): ?Document
    {
        $annotationsClass = $this->getReflector($input)->getClassAnnotations() ?: [];

        if (!$annotationsClass->has(Document::ANNOTATION)) {
            return null;
        }

        /** @var Document|null $document */
        $document = $this->getAnnotationInstance(
            $annotationsClass->get(Document::ANNOTATION)
        );

        return $document->setFuncIterableTag(function () use ($input) {
            return $this->parseClass($input);
        })->setFuncIterableTag(function () use ($input) {
            return $this->parseClassItems($input, Tag::ANNOTATION);
        })->setFuncIterableAttribute(function () use ($input) {
            return $this->parseClassItems($input, Attribute::ANNOTATION);
        });
    }

    /**
     * @param object $input
     * @return array
     * @throws \ReflectionException
     */
    private function parseClass(object $input): \Generator
    {
        $annotationsClass = $this->getReflector($input)->getClassAnnotations() ?: [];

        foreach ($annotationsClass->getAll(Tag::ANNOTATION) as $annotation) {
            if (!$this->storage->contains($annotation)) {
                $this->storage[$annotation] = $this->parseAnnotation($annotation);
            }

            /** @var Tag $tag */
            $tag = clone $this->storage[$annotation];

            yield $tag->setFuncIterableTag(function () use ($input) {
                return $this->parseClassItems($input, Tag::ANNOTATION);
            })->setFuncIterableAttribute(function () use ($input) {
                return $this->parseClassItems($input, Attribute::ANNOTATION);
            });
        }
    }

    /**
     * @param object $input
     * @param string $name
     * @return \Generator
     * @throws \ReflectionException
     */
    private function parseClassItems(object $input, string $name): \Generator
    {
        $reflector = $this->getReflector($input);
        $annotationsProperties = $reflector->getPropertiesAnnotations() ?: [];
        $annotationsMethod = $reflector->getMethodsAnnotations() ?: [];

        foreach (array_merge($annotationsProperties, $annotationsMethod) as $propertyOrMethod => $annotations) {
            switch (true) {
                case property_exists($input, $propertyOrMethod):
                    $propOrMethod = new \ReflectionProperty($input, $propertyOrMethod);
                    break;
                case method_exists($input, $propertyOrMethod):
                    $propOrMethod = new \ReflectionMethod($input, $propertyOrMethod);
                    break;
                default:
                    $propOrMethod = null;
            }

            if (is_null($propOrMethod)) {
                continue;
            }

            if ($propOrMethod->isPrivate() || $propOrMethod->isProtected()) {
                $propOrMethod->setAccessible(true);
            }

            foreach ($annotations->getAll($name) as $annotation) {
                $value = $propOrMethod instanceof \ReflectionProperty ? $propOrMethod->getValue($input) : $propOrMethod->invoke($input);

                yield $this->parseAnnotation($annotation, $value);
            }
        }
    }

    /**
     * @param Annotation $annotation
     * @param null $value
     * @return object|null
     * @throws \ReflectionException
     */
    private function parseAnnotation(Annotation $annotation, $value = null): ?object
    {
        switch ($annotation->getName()) {
            case Tag::ANNOTATION:
                /** @var Tag $tag */
                $tag = $this->getAnnotationInstance(
                    $annotation, (!is_iterable($value) || !($value instanceof \Iterator)) ? (string)$value : null
                );

                if (is_iterable($value) || $value instanceof \Iterator) {
                    $tag->setFuncIterableTag(function () use ($value) {
                        foreach ($value as $val) {
                            yield $this->parseClass($val);
                        }
                    });
                } elseif (is_object($value)) {
                    $tag->setFuncIterableTag(function () use ($value) {
                        return $this->parseClass($value);
                    });
                }

                return $tag;
            case Attribute::ANNOTATION:
                $attribute = $this->getAnnotationInstance($annotation);

                if (is_null($attribute->getValue())) {
                    $attribute->setValue(
                        (!is_iterable($value) || !($value instanceof \Iterator)) ? (string)$value : null
                    );
                }

                return $attribute;
            default:
                return null;
        }
    }

    /**
     * @param Annotation $annotation
     * @return object|null
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function getAnnotationInstance(Annotation $annotation, ?string $val = null): ?object
    {
        if (!$class = self::getReflectionClass($annotation->getName())) {
            return null;
        }

        foreach ($class->getConstructor()->getParameters() as $parameter) {
            $arg = $annotation->getArgument($parameter->getName());

            if (is_iterable($arg)) {
                foreach ($arg as $key => $value) {
                    $arg[$key] = $this->getAnnotationInstance($value);

                    if ($arg[$key] instanceof Attribute && is_null($arg[$key]->getValue())) {
                        $arg[$key]->setValue($val);
                    }
                }
            }

            if (!$arg && !$parameter->isOptional()) {
                throw new \Exception(
                    "Argument \"{$parameter->getName()}\" required for \"{$annotation->getName()}\""
                );
            }

            $deps[] = $arg;
        }

        return $class->newInstance(...$deps ?? []);
    }
}