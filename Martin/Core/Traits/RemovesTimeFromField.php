<?php

namespace Martin\Core\Traits;

use Carbon\Carbon;


trait RemovesTimeFromField {

    public function removeTime($val)
    {
        if ($val instanceof Carbon)
            return $val->format('Y-m-d');

        if ($val == null)
            return "";

        if ($val == "-0001-11-30 00:00:00")
            return "";

        if (preg_match('/^(20[0-9]{2}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1})$/', $val))
            return $val;

        if ($val == "0000-00-00 00:00:00")
            return "";

        return Carbon::createFromFormat('Y-m-d H:i:s', $val)->format('Y-m-d');
    }
}