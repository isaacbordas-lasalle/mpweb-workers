<?php

include dirname(__FILE__) . '/vendor/autoload.php';

use \Gumlet\ImageResize;

class ResizeAndUpload
{
    const IMAGE_SIZES = [100, 150];
    private $imagename;
    private $resizedImages;

    public function __construct(string $imagename)
    {
        $this->imagename = $imagename;
        $this->resizedImages = [];
        $this->resize();
        $this->upload();
    }

    private function resize()
    {
        foreach (ResizeAndUpload::IMAGE_SIZES as $size):
            try {
                echo "Resizing to " . $size . " x " . $size . PHP_EOL;
                $image = new ImageResize($this->imagename);
                $image->resize($size, $size);
                $image->save('resized_' . $size . '_' . $this->imagename);
                $this->resizedImages[] = 'resized_' . $size . '_' . $this->imagename;
            } catch (\Gumlet\ImageResizeException $e) {
                echo 'There was a problem resizing image: ' . $e->getMessage();
            }
        endforeach;
    }

}

$result = new ResizeAndUpload($argv[1]);
