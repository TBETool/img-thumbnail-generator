# php-image-resize
resize image to desired height/width or use it to generate thumbnail images

## Installation
```
composer require tbetool/img-thumbnail-generator
```

## Usage
```
$thumb = new ImgThumbnailGenerator($source, $destination, $desired_width, $desired_height, $quality);
```

## Parameters
* **$source** => (required) path to source image to generate thumbnail
* **$destination** => (required) absolute destination path to save thumbnail to
* **$desired_width** => (required) desired width of the image to resize to
* **$desired_height** => desired height of the image to resize to, *If not provided, proportional height to widht ratio is used*
* **$quality** => quality of the thumbnail, *Default to 90*

## Example
```
$thumb = new ImgThumbnailGenerator('path_to/myImage.jpg', 'path_to/newThumb.jpp', 250, 250, 100);
```

## Returns
**True:** when thumbnail is generated at destination 
**False:** if thumbnail generation is failed

## Tips
* To not provide `desired_height` parameter and set `quality` parameter, pass `NULL` in place of `$desired-height`
* To keep `$desired_height` and `$quality` to its default, call function like
```
$thumb = new ImgThumbnailGenerator($source, $destination, $desired_width);
```

## Developer
Anuj Sharma (https://anujsh.gitlab.io)
## Repository
TBE (http://thebornengineer.com)
