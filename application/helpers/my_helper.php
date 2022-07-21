<?php
defined('BASEPATH') or exit('No direct script access allowed');

function tampil_media($file, $width = "", $height = "")
{
	$ret = '';

	$pc_file = explode(".", $file);
	$eks = end($pc_file);

	$eks_video = array("mp4", "flv", "mpeg");
	$eks_audio = array("mp3", "acc");
	$eks_image = array("jpeg", "jpg", "gif", "bmp", "png");
	$eks_pdf = array("pdf");


	if (!in_array($eks, $eks_video) && !in_array($eks, $eks_audio) && !in_array($eks, $eks_image) && !in_array($eks, $eks_pdf)) {
		$ret .= '';
	} else {
		if (in_array($eks, $eks_video)) {
			if (is_file("./" . $file)) {
				$ret .= '<p><video width="' . $width . '" height="' . $height . '" controls>
                <source src="' . base_url() . $file . '" type="video/mp4">
                <source src="' . base_url() . $file . '" type="application/octet-stream">Browser tidak support</video></p>';
			} else {
				$ret .= '';
			}
		}

		if (in_array($eks, $eks_audio)) {
			if (is_file("./" . $file)) {
				$ret .= '<p><audio width="' . $width . '" height="' . $height . '" controls>
				<source src="' . base_url() . $file . '" type="audio/mpeg">
				<source src="' . base_url() . $file . '" type="audio/wav">Browser tidak support</audio></p>';
			} else {
				$ret .= '';
			}
		}
		if (in_array($eks, $eks_pdf)) {
			if (is_file("./" . $file)) {
				$ret .= '<embed type="application/pdf" width="100%" height="500px" src="' . base_url() . $file . '">';
			} else {
				$ret .= '';
			} 
		}

		if (in_array($eks, $eks_image)) {
			if (is_file("./" . $file)) {
				$ret .= '<image class="thumbnail w-500" src="' . base_url() . $file . '" style="width: ' . $width . '; height: ' . $height . ';">';
			} else {
				$ret .= '';
			}
		}
	}


	return $ret;
}
