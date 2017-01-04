<?php

namespace AppBundle\Doctrine;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Description of UploadFileMover
 *
 * @author Manoj
 */
class UploadFileMoverListener {

	public function moveUploadedFile(UploadedFile $file, $uploadBasePath, $relativePath, $filename) {
		$originalName = $filename;
		// use filemtime() to have a more determenistic way to determine the subpath, otherwise its hard to test.
		// $relativePath = date('Y-m', filemtime($file->getPath()));
		$targetFileName = $relativePath . DIRECTORY_SEPARATOR . $originalName;
		$targetFilePath = $uploadBasePath . DIRECTORY_SEPARATOR . $targetFileName;
		$ext = $file->getExtension();
		$i=1;
		while (file_exists($targetFilePath) && md5_file($file->getPath()) != md5_file($targetFilePath)) {
			if ($ext) {
				$prev = $i == 1 ? "" : $i;
				$targetFilePath = $targetFilePath . str_replace($prev . $ext, $i++ . $ext, $targetFilePath);

			} else {
				$targetFilePath = $targetFilePath . $i++;
			}
		}

		$dirCheck_array = explode( '/', $relativePath );
		$dirCheckSub = $dirCheck_array[ 0 ];

		$dirCheck = $uploadBasePath . DIRECTORY_SEPARATOR . $dirCheckSub;
		if ( !is_dir($dirCheck) ) {
			mkdir($dirCheck);
		}


		$targetDir = $uploadBasePath . DIRECTORY_SEPARATOR . $relativePath;
		//$targetDir = "uploads/test";
//		print_r($targetDir);
		if (!is_dir($targetDir)) {
			$oldmask = umask(0);
			$ret = mkdir($targetDir, 0777);
			umask($oldmask);
			if (!$ret) {
				throw new \RuntimeException("Could not create target directory to move temporary file into.");
			}
		}

		$file->move($targetDir, $filename);

		return str_replace($uploadBasePath . "/", "", $targetFilePath);
	}

}

