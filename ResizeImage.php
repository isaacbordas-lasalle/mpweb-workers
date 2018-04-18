<?php

namespace App;

use \Gumlet\ImageResize;

class ResizeImage
{
    private $dispatcher;
    private $imagename;
    private $width;
    private $height;

    public function __construct(string $imagename, int $width, int $height, $dispatcher)
    {
        $this->imagename = $imagename;
        $this->width = $width;
        $this->height = $height;
        $this->dispatcher = $dispatcher;
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

        echo "Resizing complete. Publishing event" . PHP_EOL;
		$event = new ResizeImageEvent($this);
        $this->dispatcher->dispatch(ResizeImageEvent::NAME, $event);        
        
    }
}