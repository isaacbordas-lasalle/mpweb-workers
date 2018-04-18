<?php

include dirname(__FILE__) . '/vendor/autoload.php';

use \Gumlet\ImageResize;
use Aws\S3\S3Client;
use Aws\S3\Exception\PermanentRedirectException;
use Aws\S3\Exception\S3Exception;
use Aws\Exception\CredentialsException;

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

    private function upload()
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'eu-west-1'
          ]
        ]);

        try {
            foreach ($this->resizedImages as $resized) :
                echo "Uploading " . $resized . " to S3" . PHP_EOL;
                $result = $s3->putObject(array(
                    'Bucket' => 'mpweb-s3',
                    'Key'    => $resized,
                    'ACL' => 'public-read',
                    'CacheControl' => 'max-age=1209600',
                    'SourceFile' => dirname(__FILE__) . '/' . $resized
                ));
            endforeach;
        } catch (PermanentRedirectException $e) {
            echo $e->getMessage();
        } catch (S3Exception $e) {
            echo $e->getMessage();
        } catch (CredentialsException $e) {
            echo $e->getMessage();
        }
    }

}

$result = new ResizeAndUpload($argv[1]);
