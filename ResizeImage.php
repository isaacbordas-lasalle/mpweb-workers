<?php

namespace App;

use \Gumlet\ImageResize;

class ResizeImage
{
    private $imagename;
    private $width;
    private $height;

    public function __construct(string $imagename, int $width, int $height)
    {
        $this->imagename = $imagename;
        $this->width = $width;
        $this->height = $height;
    }

    public function resize()
    {
        try {
            echo "Resizing to " . $this->width . " x " . $this->height . PHP_EOL;
            $image = new ImageResize('img/original/' . $this->imagename);
            $image->resize($this->width, $this->height);
            $image->save('img/modified/resized_' . $this->width . 'x' . $this->height . '_' . $this->imagename);
        } catch (\Gumlet\ImageResizeException $e) {
            echo 'There was a problem resizing image: ' . $e->getMessage();
        }
    }
}