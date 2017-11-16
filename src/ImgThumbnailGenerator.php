<?php
namespace TBETool;

class ImgThumbnailGenerator
{
    private $image_type;
    private $source;
    private $destination;
    private $desired_width;
    private $desired_height;
    private $quality;

    function __construct($source, $destination, $desired_width, $desired_height = NULL, $quality = 90)
    {
        $this->source = $source;
        $this->destination = $destination;
        $this->desired_width = $desired_width;
        $this->desired_height = $desired_height;
        $this->quality = $quality;

        return $this->_generate();
    }

    /**
     * generate thumbnail image
     * @return bool
     */
    private function _generate()
    {
        if (!is_file($this->source)) {
            die('Source given is not a valid file.');
        }

        /**
         * check for image extension and set image_type
         */
        $allowed_image_types = ['jpg', 'jpeg', 'png'];
        $ext_explode('.', $this->source);
        if (in_array(end($ext_explode), $allowed_image_types)) {
            $this->image_type = strtolower(end($ext_explode));
        } else {
            die('Not a valid image supplied. Only supported Image is JPEG or PNG');
        }
        
        /*
        if (exif_imagetype($this->source) == IMAGETYPE_JPEG) {
            // create jpeg image
            $this->image_type = 'jpeg';

            $source_image = imagecreatefromjpeg($this->source);
        } else if (exif_imagetype($this->source) == IMAGETYPE_PNG) {
            // create png type
            $this->image_type = 'png';

            $source_image = imagecreatefrompng($this->source);
        } else {
            die('Not a valid image supplied. Only supported Image is JPEG or PNG');
        }
        */

        /**
         * check and set destination
         */
        $this->_getDestination();

        /* get height and width of the image */
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        
        /* set desired height if not set by user */
        if ($this->desired_height == NULL) {
            $this->desired_height = floor($height * ($this->desired_width / $width));
        }

        /* create a new virtual image */
        $virtual_image = imagecreatetruecolor($width, $height);

        /* copy source image at a resized size */
        imagecopyresampled(
            $virtual_image,
            $source_image,
            0,
            0,
            0,
            0,
            $this->desired_width,
            $this->desired_height,
            $width,
            $height
        );

        /* create a physical image to its destination */
        return imagejpeg($virtual_image, $this->destination, $this->quality);
    }

    /**
     * create destination directory if not already exists
     * @return bool
     */
    private function _getDestination()
    {
        if (file_exists($this->destination)) {
            return true;
        }

        $parent_directory = dirname($this->destination);

        if (!is_file($parent_directory)) {
            if (mkdir($parent_directory, 0777, true)) {
                return true;
            } else {
                die('unable to create destination directory');
            }
        }

        return true;
    }
}
