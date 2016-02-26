<?php

namespace HtmlDriven\CorsProxy;

/**
 * Provides some helper methods.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class Helpers
{
	/**
	 * Check whether given file exists.
	 * 
	 * @param string
	 * @return void
	 * @throws FileNotFoundException
	 */
	public static function checkFileExists($file)
	{
		if (!is_file($file)) {
			throw new FileNotFoundException(sprintf("File '%s' does not exist or not accessible.", $file));
		}
	}
	
	/**
	 * Makes sure the path is absolute.
	 * 
	 * @param string
	 * @param string
	 * @return string
	 */
	public static function absolutizeFilepath($rootPath, $filepath)
	{
		if (substr($filepath, 0, 1) === '.') {
			$filepath = $rootPath . DIRECTORY_SEPARATOR . $filepath;
		}
		return $filepath;
	}
}
