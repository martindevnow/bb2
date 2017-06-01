<?php


trait CanSeedFromCSV {

    /**
     * @param $table
     * @param $file_path
     */
    public function seedFromCSV($table, $file_path) {

        $col_names = [];

        $file_path = base_path() . $file_path;

        $handle = fopen($file_path,"r");
        while ($data = fgetcsv($handle,1500,",","'")) {
            // Build the header columns if required
            if (count($col_names) == 0) {
                $col_names = $this->getColNamesFromFirstRow($data);
                continue;
            }

            // ## in the first column Denotes a comment, skip this line
            if (isset($data[0]) && $data[0] == "##")
                continue;

            // clear previous insert data
            $insert_data = [];
            foreach ($data as $col_number => $value) {

                // Skip if empty
                if (trim($value) == "")
                    continue;



                // Check to see if the data is relational
                if ($this->dataIsRelational($value)) {
                    $model = $this->getRelationalModel($value);
                    if ($model == null)
                        dd ([$data, $col_number, $col_names[$col_number], $value]);

                    $insert_data[$col_names[$col_number]] = $model->id;
                    continue;
                }

                $insert_data[$col_names[$col_number]] = $value;
            }
            DB::table($table)->insert($insert_data);
        }
    }

    /**
     * @param $data
     * @return array
     */
    private function getColNamesFromFirstRow($data) {
        $header = [];
        foreach ($data as $col_number => $col_name)
            $header[$col_number] = $col_name;
        return $header;
    }

    /**
     * @param $value
     * @return bool
     */
    private function dataIsRelational($value) {
        if (stripos($value, '===') === false)
            return false;
        return true;
    }

    /**
     * @param $value
     * @return mixed
     */
    private function getRelationalModel($value) {
        $broken = explode('===', $value);

        $model_broken = explode('->', $broken[0]);
        $table = $model_broken[0];
        $field = $model_broken[1];

        // remove the first part of the equation
        unset($broken[0]);
        $value = implode('===', $broken);

        // Allow recursive nesting of queries (ie. "subscriptions->pet_id===pets->name===Dog1"
        // On the first iteration,  $table = subscriptions
        //                          $field = pet_id
        //                          $value = pets->name===Dog1
        // Then, it runs through again....
        // and  $table = pets
        //      $field = name
        //      $value = Dog1
        // Then it returns the model back to the first iteration
        // and it takes the ID of the second iteration's result (ie. 10)
        // so now $value = 10 and the first iteration of the code completes.
        // HOWEVER, this only works when the parent (of the nested lookups) is referencing the ID of that table.
        if (strpos($value, '===') !== false)
            $value = $this->getRelationalModel($value)->id;

        return DB::table($table)->where($field, '=', $value)->first();
    }
}