<?php

namespace App;

use Symfony\Component\EventDispatcher\Event;

class ResizeImageEvent extends Event
{
	const NAME = 'image.resize';
    
}