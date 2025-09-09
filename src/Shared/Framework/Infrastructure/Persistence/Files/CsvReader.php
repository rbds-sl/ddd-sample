<?php

declare(strict_types=1);

namespace CoverManager\Shared\Framework\Infrastructure\Persistence\Files;

use RuntimeException;

final class CsvReader
{
    /**
     * @return iterable|CsvReaderLine[]
     */
    public function read(string $fileName, string $separator = ';'): iterable
    {

        $file = fopen($fileName, 'rb');
        if ($file === false) {
            throw new RuntimeException('Can\'t open file ' . $fileName);
        }
        $header = null;

        while (($data = fgetcsv($file, 1000, $separator)) !== false) {
            if ($header === null) {
                if (!$data) {
                    continue;
                }
                $header = $this->importHeader($data);

                continue;
            }
            yield new CsvReaderLine($data, $header);
        }
    }

    /**
     * @param  array<string|null>  $data
     * @return array<string>
     */
    private function importHeader(array $data): array
    {
        $header = [];
        foreach ($data as $key => $item) {
            if ($item === null) {
                throw new RuntimeException('Header can not be null');
            }
            $header[strtolower($item)] = $key;
        }

        return $header;
    }
}
