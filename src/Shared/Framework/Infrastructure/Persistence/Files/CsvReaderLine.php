<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Infrastructure\Persistence\Files;

use CoverManager\Shared\Framework\Helpers\MixedHelper;
use CoverManager\Shared\Framework\Helpers\StringHelper;
use DateTimeZone;
use Exception;
use Illuminate\Support\Carbon;
use RuntimeException;

final class CsvReaderLine
{
    /** @var array <string|null> */
    private array $data;

    /** @var array <string> */
    private array $header;

    /**
     * @param  array<string|null>  $data
     * @param  array<string>  $header
     */
    public function __construct(array $data, array $header)
    {
        $this->data = $data;
        $this->header = $header;
    }

    /**
     * @return mixed|null
     */
    private function getItem(string $column, ?string $alternativeName = null): mixed
    {
        $position = $this->header[strtolower($column)] ?? null;
        if ($position === null && $alternativeName) {
            $position = $this->header[strtolower($alternativeName)] ?? null;
            if ($position === null) {
                return null;
            }
        }

        return $this->data[$position];
    }

    public function getString(string $column, ?string $alternativeName = null): string
    {
        return MixedHelper::getString($this->getItem($column, $alternativeName));
    }

    public function getStringOrNull(string $column, ?string $alternativeName = null): ?string
    {
        return MixedHelper::getStringOrNull($this->getItem($column, $alternativeName));
    }

    public function getInt(string $column, ?string $alternativeName = null): int
    {
        $value = $this->getItem($column, $alternativeName);
        if (is_string($value) || is_numeric($value)) {
            return (int) $value;
        }
        throw new RuntimeException('Can not convert to integer ' . $column);
    }

    /**
     * @throws Exception
     */
    public function getFloat(string $column, ?string $alternativeName = null): float
    {
        return StringHelper::getNumberFromString(MixedHelper::getString($this->getItem($column, $alternativeName)));
    }

    public function getBoolean(string $column, ?string $alternativeName = null): bool
    {
        $value = MixedHelper::getString($this->getItem($column, $alternativeName));

        return $value === 'true' || $value === '1';
    }

    public function getCarbonDate(string $colum, ?string $alternativeName = null, string $format = 'Y-m-d H:i:s', string $timeZone = 'UTC'): Carbon
    {
        $string = $this->getString($colum, $alternativeName);
        try {
            /** @var Carbon $date */
            $date = Carbon::createFromFormat($format, $string, new DateTimeZone($timeZone));
        } catch (Exception $exception) {
            throw new RuntimeException($exception->getMessage() . '/' . $string);
        }

        return $date;
    }
}
