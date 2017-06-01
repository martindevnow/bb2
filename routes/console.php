<?php

use Illuminate\Foundation\Inspiring;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('resize', function () {

    $folder = '/barfbento/img/treats/';
    $destinationFolder = 'square/';

    $this->comment('Getting Files...');
    $files = scandir(public_path($folder));
    foreach ($files as $file) {
        $this->comment($file);
        $extension = getExtensionFromString($file);
        $this->comment($extension);

        try {
            if (in_array($extension, ['jpg', 'jpeg']))
                $image = imagecreatefromjpeg(public_path($folder . $file));
            elseif (in_array($extension, ['png']))
                $image = imagecreatefrompng(public_path($folder . $file));
            elseif (in_array($extension, ['gif']))
                $image = imagecreatefromgif(public_path($folder . $file));
            else
                continue;
        } catch (Exception $e) {
            $this->comment('Failed on this image...');
            continue;
        }


        $this->comment('Loading ' . $file);
        $x = imagesx($image);
        $y = imagesy($image);

        $this->comment('X: ' . $x);
        $this->comment('Y: ' . $y);
        $startX = $startY = 0;

        if ($x > $y) {
            $startX = intval(($x - $y) / 2);
        } else if ($y > $x) {
            $startY = intval(($y - $x) / 2);
        }

        $size = min ($x, $y);

        $newImage = imagecrop($image, [
            'x' => $startX,
            'y' => $startY,
            'width' => $size,
            'height' => $size]);

        if ($newImage === false) {
            $this->comment('Could not resize '. $file);
            continue;
        }

        if (in_array($extension, ['jpg', 'jpeg']))
            imagejpeg($newImage, public_path($folder . 'square/' . $file));
        elseif (in_array($extension, ['png']))
            imagepng($newImage, public_path($folder . 'square/' . $file));
        elseif (in_array($extension, ['gif']))
            imagegif($newImage, public_path($folder . 'square/' . $file));
        else
            continue;
        $this->comment('New Image Saved.');


    }
});
