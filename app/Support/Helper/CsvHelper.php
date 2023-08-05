<?php

namespace App\Support\Helper;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use RuntimeException;

readonly class CsvHelper
{
    /**
     * @throws \PhpOffice\PhpSpreadsheet\Calculation\Exception
     * @throws Exception
     */
    public static function readCsv(string $filePath, string $sheetName): array
    {
        $excel = IOFactory::load($filePath);
        $worksheet = $excel->getSheetByName($sheetName);
        if (is_null($worksheet)) {
            throw new RuntimeException('Отсутствует страница ' . $sheetName);
        }
        $list = [];
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            foreach ($cellIterator as $cell) {
                $cellIndex = $cell->getColumn();
                $returnValue = null;
                if ($cell->getValue() !== null) {
                    if ($cell->getValue() instanceof RichText) {
                        $returnValue = $cell->getValue()->getPlainText();
                    } elseif ($cell->getDataType() === 'f' && str_starts_with($cell->getValue(), '=')) {
                        $returnValue = $worksheet->getCell(str_replace('=', '', $cell->getValue()))->getCalculatedValue(
                        );
                    } else {
                        $returnValue = $cell->getCalculatedValue();
                    }

                    $style = $worksheet->getParentOrThrow()->getCellXfByIndex($cell->getXfIndex());
                    $returnValue = NumberFormat::toFormattedString(
                        $returnValue,
                        $style->getNumberFormat()->getFormatCode() ?? NumberFormat::FORMAT_GENERAL
                    );
                }
                $list[$row->getRowIndex()][$cellIndex] = $returnValue;
            }
        }
        $excel->disconnectWorksheets();
        unset($excel);

        return $list;
    }
}
