<?php

namespace App\Libs;

class CSVUtil
{
    /**
     * Export csv file with array data and fields
     *
     * @param  array  $data not null,
     * @param  array  $headers not null,
     * @return string
     */
    public static function exportCSVFile($data, $headers)
    {
        $file = fopen('php://output', 'w');

        $headerCopy = array_map(function ($value) {
            if (strpos($value, ' ') === false) {
                $value = '"'.$value.'"';
            }

            return $value;
        }, $headers);

        ob_start();

        fputcsv($file, $headerCopy);

        foreach ($data as $item) {

            $lineData = [];

            for ($i = 0; $i < count($headers); $i++) {
                $value = $item[$headers[$i]] ?? '';

                if (strpos($value, ' ') === false) {
                    $value = '"'.$value.'"';
                }

                $lineData[] = $value;
            }

            fputcsv($file, $lineData, ',', '"');
        }

        fclose($file);

        $csv = ob_get_clean();

        $csv = str_replace('""', '"', str_replace('""', '"', $csv));

        return $csv;
    }
}
