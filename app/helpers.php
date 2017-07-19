<?php

class Columns {
    public $fields = array();

    function __construct(string $firstLine)
    {
        $fields = explode(',', $firstLine);
        foreach ($fields as $field) {
            $this->fields[] = new Column($field);
        }
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

    private function trimQuotes($element): string {
        $element = substr($element, 0, -1);
        $element = substr($element, 1);
        return $element;
    }

    public function getField(): string {
        return $this->table ? $this->table . '->' . $this->field . '===' : '';
    }
}

function getExtensionFromString($str): string {
    $parts = explode('.', $str);
    return $parts[count($parts) - 1];
}


// convertTsvToCsv('meal_meat', '/seeds/fromGoogle/meal_meat.csv');
function convertTsvToCsv(string $table, string $filepath) {
    $columns = null;
    $newFileContents = "";
    $handle = fopen(base_path() . $filepath, "r");

    if($handle !== FALSE) {
        while ( ! feof($handle) ) {

            $currentLine = "";
            $index = 0;

            if (! $columns ) {
                foreach( fgetcsv($handle, 0, "\t") as $csv_item)
                    $currentLine .= "'{$csv_item}',";

                $currentLine = substr($currentLine, 0,-1) . "\n";

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
            }
            $newFileContents .= $currentLine;
        }

        fclose($handle);

        file_put_contents(base_path() . '/seeds/csv/' . $table . '.csv', $newFileContents );
    }
}