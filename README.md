# mpweb-workers
Script to resizing images with RabbitMQ Workers

Usando el código de modificación de tamaño de imágenes crea un sistema con workers que permita publicar una tarea con un mensaje que diga el tamaño de la imagen, así como el origen. El worker debe recibir el mensaje y procesar la imagen, haciendo el cambio de tamaño. 

Ejemplo de uso:

$ ls img/original
wallpaper.jpg

$ php publish_resize_job.php img/original/wallpaper.jpg 100 100

$ php worker.php
Job resize job detected
Resizing image img/original/wallpaper.jpg at 100x100
Resulting image saved at img/modified/wallpaper_100_100.jpg
