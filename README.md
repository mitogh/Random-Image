Random Image [![Build Status](https://travis-ci.org/mitogh/Random-Image.svg)](https://travis-ci.org/mitogh/Random-Image)
===================

> Easily random image generation from the library of attachments or from
 a post, page or custom post type ID.  

## Description

Whith this small utility you can easy and fast access to the group of
random images from the library or from a post using the ID of the post,
you can access to the IDs of this images or the `src` of each image by
size.  

## Requirements.  

- WordPress
- PHP 5.3 >=

## Usage

In order to access to the public functions you need to create an
instance of `RandomImage` class as follows: 

```php
$randomImage = new mitogh\RandomImage();
```

Optionally you can pass an array of arguments to update some arguments
before to retrieve the random images, the arguments are: 

- count: you can specify the number of images to be searched, default is 1.
- parent_ID: you can specify the ID of the page, post, post type from
  where to search the images if you don't want to search on the entiry
library of attachments, default is null and searches the entiry library.  

So for example if you want to have 3 random images from the page with
the ID: 2.  

```php
$args = array(
  'count' => 3,
  'parent_ID' => 2,
);
$randomImage = new mitogh\RandomImage( $args );
```

**Filters**

Aditionally you can update the default mime of the searched files, using
the filter `mitogh_rand_image_mime_type`, by default the mime types are: 

```php
image/jpeg
image/gif
image/png
image/bmp
image/tiff
```

You can update this by using the filter and returning an array with the
type, for example to search only gif images:  

```php
add_filter( 'mitogh_rand_image_mime_type', function( $default_types ) ) {
    return array(
		'image/gif',
    );
});
```

## Public methods

You have access to 2 methods with the instance to `RandomImage`, the
methods are:   

**get_ids**

With this method you can access to the ID of each image, and by having
the ID of the image you can use another functions to operate over each
image as follows: 

```php
$randomImage = new mitogh\RandomImage();
$images_id = $randomImage->get_ids();
// Now images_id has an array with the id of each image, and you can use 
// each id to operate over each image.
```

**get_srcs**

This method will return an array with the src attribute of each image so
you can use each value in a `<img>` tag. Aditionally you can specify the
size of the images (all of them) before returned.

```php
$randomImage = new mitogh\RandomImage();
$images_src = $randomImage->get_srcs( 'full' );
// Now images_src has an array with the src value of the images with the
// full size.
```
