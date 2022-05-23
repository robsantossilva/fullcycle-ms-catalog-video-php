<?php

namespace Core\Domain\Entity\Traits;

use Exception;
use DateTime;

trait MethodsMagicsTrait
{
    public function __get($property)
    {

        if ($property == 'id' && isset($this->{$property}))
            return (string) $this->id;

        if ($property == 'createdAt' && isset($this->{$property}))
            return (string) $this->createdAt->format('Y-m-d H:i:s');


        if (isset($this->{$property}))
            return $this->{$property};

        $className = get_class($this);
        throw new Exception("Property {$property} not found in class {$className}");
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(string $format = 'Y-m-d H:i:s'): string
    {
        return (string) $this->createdAt->format($format);
    }
}
