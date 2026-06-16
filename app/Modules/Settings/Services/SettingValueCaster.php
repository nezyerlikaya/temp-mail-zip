<?php

namespace App\Modules\Settings\Services;

use App\Modules\Settings\Enums\SettingType;
use App\Modules\Settings\Exceptions\InvalidSettingValueException;

final class SettingValueCaster
{
    public function cast(string $key, SettingType $type, mixed $value): mixed
    {
        return match ($type) {
            SettingType::String => $this->castString($key, $value),
            SettingType::Integer, SettingType::DurationSeconds => $this->castInteger($key, $value),
            SettingType::Boolean => $this->castBoolean($key, $value),
            SettingType::Decimal => $this->castDecimal($key, $value),
            SettingType::Array => $this->castArray($key, $value),
        };
    }

    public function encode(string $key, SettingType $type, mixed $value): string
    {
        return json_encode(
            $this->cast($key, $type, $value),
            JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    public function decode(string $key, SettingType $type, ?string $value): mixed
    {
        if ($value === null) {
            return null;
        }

        $decoded = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

        return $this->cast($key, $type, $decoded);
    }

    private function castString(string $key, mixed $value): string
    {
        if (! is_string($value)) {
            throw InvalidSettingValueException::forKey($key, 'expected string');
        }

        return $value;
    }

    private function castInteger(string $key, mixed $value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (is_string($value) && preg_match('/^-?\d+$/', $value) === 1) {
            return (int) $value;
        }

        throw InvalidSettingValueException::forKey($key, 'expected integer');
    }

    private function castBoolean(string $key, mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === 1 || $value === '1' || $value === 'true') {
            return true;
        }

        if ($value === 0 || $value === '0' || $value === 'false') {
            return false;
        }

        throw InvalidSettingValueException::forKey($key, 'expected explicit boolean');
    }

    private function castDecimal(string $key, mixed $value): float
    {
        if (is_int($value) || is_float($value)) {
            return (float) $value;
        }

        if (is_string($value) && preg_match('/^-?\d+(\.\d+)?$/', $value) === 1) {
            return (float) $value;
        }

        throw InvalidSettingValueException::forKey($key, 'expected decimal');
    }

    /**
     * @return array<array-key, mixed>
     */
    private function castArray(string $key, mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        throw InvalidSettingValueException::forKey($key, 'expected array');
    }
}
