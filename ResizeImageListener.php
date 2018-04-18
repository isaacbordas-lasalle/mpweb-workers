<?php

namespace App;

class ResizeImageListener
{
	public function send()
	{
		echo "ResizeImageListener: Entrando en el listener" . PHP_EOL;

		echo "[x] Resizing " . PHP_EOL;

		echo "ResizeImageListener: función ejecutada!" . PHP_EOL;
	}

}