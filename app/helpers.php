<?php

use Martin\Subscriptions\Package;

function getSizes() {
    return [
        ['label' => 'S',    'min' => 5,     'max' => 14,    'base' => 35.75,    'inc' => 2.000],
        ['label' => 'M',    'min' => 15,    'max' => 49,    'base' => 41.60,    'inc' => 1.625],
        ['label' => 'L',    'min' => 50,    'max' => 94,    'base' => 61.10,    'inc' => 1.755],
        ['label' => 'XL',   'min' => 95,    'max' => 139,   'base' => 83.85,    'inc' => 1.950],
        ['label' => 'XXL',  'min' => 140,   'max' => 220,   'base' => 98.80,    'inc' => 2.145],
    ];
}

function getSize($weight) {
    return collect(getSizes())
        ->filter(function($size) use ($weight) {
            return $size['min'] <= $weight && $size['max'] >= $weight;
        })->first();
}

function weeksAtATime($shipping_modifier) {
    switch ($shipping_modifier) {
        case 0:
            return 4;
        case 1:
            return 2;
        case 2:
        default:
            return 1;
    }
}

function roundToNearestFive($num) {
    return round($num / 5) * 5;
}

function calculateCost($weight, Package $package) {
    if ($weight < 5)
        return 0;

    if (!$package)
        return 0;

    $size = getSize($weight);

    return $size['base']
        + (roundToNearestFive($weight) - $size['min']) / 5 * $size['inc']
        + $package->level* 5
        + $package->customization * 3;
}


class Columns {
    public $fields = array();

    function __construct(string $firstLine)
    {
        $fields = explode(',', $firstLine);
        foreach ($fields as $field) {
            $this->fields[] = new Column($field);
        }
    }

    public function getColumnLine() {
        $result = "";
        foreach ($this->fields as $field) {
            $result .= "'" . $field->getColumn() . "',";
        }
        $result = substr($result, 0, -1) . "\n";
        return $result;
    }
}

class Column {

    public $table = null;
    public $field = null;

    function __construct($element)
    {
        $element = $this->trimQuotes($element);
        if (stripos($element, '.') === false) {
            $this->field = $element;
        } else {
            $split = explode('.', $element);
            $this->table = $split[0];
            $this->field = $split[1];
        }
    }

    private function trimQuotes($element) {
        $element = substr($element, 0, -1);
        $element = substr($element, 1);
        return $element;
    }

    public function getField() {
        return $this->table ? $this->table . '->' . $this->field . '===' : '';
    }

    public function getColumn() {
        return $this->table ? str_singular($this->table) . '_id' : $this->field;
    }
}

function getExtensionFromString($str) {
    $parts = explode('.', $str);
    return $parts[count($parts) - 1];
}


// convertTsvToCsv('meal_meat', '/seeds/fromGoogle/meal_meat.csv');
function convertTsvToCsv(string $table, string $filepath) {
    $columns = null;
    $newFileContents = "";
    $handle = fopen(base_path() . $filepath, "r");

    if ($handle !== FALSE) {
        while ( ! feof($handle) ) {

            $currentLine = "";
            $index = 0;

            if (! $columns ) {
                foreach( fgetcsv($handle, 0, "\t") as $csv_item)
                    $currentLine .= "'{$csv_item}',";

                $currentLine = substr($currentLine, 0, -1);

                if (trim($currentLine)) {
                    $columns = new Columns($currentLine);
                }
            }
            else
            {
                foreach( fgetcsv($handle, 0, "\t") as $csv_item) {
                    $currentLine .= "'"
                        . $columns->fields[$index]->getField() . $csv_item
                        . "',";
                    $index ++;
                }
                $currentLine = substr($currentLine, 0,-1) . "\n";

                $newFileContents .= $currentLine;
            }

        }

        fclose($handle);

        $newFileContents = $columns->getColumnLine() . $newFileContents;

        file_put_contents(base_path() . '/seeds/csv/' . $table . '.csv', $newFileContents );
    }
}