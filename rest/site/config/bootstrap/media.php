<?php
/**
 * With Helium being extension of ProdigyView, it offers the ability to manpulate images, audio and video. ProdigyView requires
 * Imagick and FFMPEG, therefore Helium requires the same.
 * 
 * The classes below can be commented out if they are not being used with out application.
 */

/**
 * Configure the options for Image and initialize the close. For using image manipulation, remember
 * that Imagick should be installed. If not needed, comment out.
 */
use prodigyview\media\Video;
use prodigyview\media\Image;
use prodigyview\media\Audio;

Image::init(array(
	'write_image' => false,
));

/**
 * Configure the options for audio manipulation. FFMPEG must be installed on the server to use.
 * If not needed, comment out.
 */
Audio::init(array());

/**
 * Configure the options for video manipulation. FFMPEG must be installed on the server to use.
 * If not needed, comment out.
 */
Video::init(array());
