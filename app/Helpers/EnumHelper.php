<?php

namespace App\Helpers;

use BackedEnum;
use Illuminate\Support\Collection;

class EnumHelper
{
    /**
     * Convert an enum to an array suitable for select options.
     *
     * @param string $enumClass The fully qualified class name of the enum
     * @return array
     */
    public static function enumToSelectArray(string $enumClass): array
    {
        if (!enum_exists($enumClass) || !is_subclass_of($enumClass, BackedEnum::class)) {
            return [];
        }

        return array_map(fn($case) => [
            'value' => $case->value,
            'label' => method_exists($case, 'descripcion') 
                ? $case->descripcion() 
                : (method_exists($case, 'nombre') ? $case->nombre() : $case->name),
        ], $enumClass::cases());
    }

    /**
     * Convert an enum to a collection suitable for select options.
     *
     * @param string $enumClass The fully qualified class name of the enum
     * @return Collection
     */
    public static function enumToSelectCollection(string $enumClass): Collection
    {
        return collect(self::enumToSelectArray($enumClass));
    }

    /**
     * Get an enum case by its value.
     *
     * @param string $enumClass The fully qualified class name of the enum
     * @param int|string $value The value to find
     * @return BackedEnum|null
     */
    public static function getEnumFromValue(string $enumClass, int|string $value): ?BackedEnum
    {
        if (!enum_exists($enumClass) || !is_subclass_of($enumClass, BackedEnum::class)) {
            return null;
        }

        return $enumClass::tryFrom($value);
    }

    /**
     * Get the description or name of an enum case by its value.
     *
     * @param string $enumClass The fully qualified class name of the enum
     * @param int|string $value The value to find
     * @return string|null
     */
    public static function getEnumLabelFromValue(string $enumClass, int|string $value): ?string
    {
        $enum = self::getEnumFromValue($enumClass, $value);
        
        if (!$enum) {
            return null;
        }

        return method_exists($enum, 'descripcion') 
            ? $enum->descripcion() 
            : (method_exists($enum, 'nombre') ? $enum->nombre() : $enum->name);
    }
} 