<?php

namespace QueueDoctrine\Type;

use Doctrine\DBAL\Types\JsonArrayType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Laminas\Stdlib\Parameters;

class ParamsType extends JsonArrayType
{
    public const PARAMS = 'params';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        /** @var Parameters $value */
        return parent::convertToDatabaseValue($value->toArray(), $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = parent::convertToPHPValue($value, $platform);
        return new Parameters($value);
    }

    public function getName(): string
    {
        return self::PARAMS;
    }
}
