<?php

namespace HtmlDriven\CorsProxy;

/**
 * Application configuration.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class Config
{
	/** @var string */
	private $urlParameterName;
	
	/** @var string */
	private $userAgent;
	
	/** @var string */
	private $templateFile;
	
	/** @var string */
	private $sitemapPath;
	
	/** @var string */
	private $sitemapTemplateFile;
	
	/** @var string */
	private $errorTemplateFile;
	
	/**
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @throws FileNotFoundException If template/sitemap/error file does not exist.
	 */
	public function __construct(
		$urlParameterName,
		$userAgent,
		$templateFile,
		$sitemapPath,
		$sitemapTemplateFile,
		$errorTemplateFile
	)
	{
		Helpers::checkFileExists($templateFile);
		Helpers::checkFileExists($sitemapTemplateFile);
		Helpers::checkFileExists($errorTemplateFile);
		
		$this->urlParameterName = $urlParameterName;
		$this->userAgent = $userAgent;
		$this->templateFile = $templateFile;
		$this->sitemapPath = $sitemapPath;
		$this->sitemapTemplateFile = $sitemapTemplateFile;
		$this->errorTemplateFile = $errorTemplateFile;
	}
	
	/**
	 * @return string
	 */
	public function getUrlParameterName()
	{
		return $this->urlParameterName;
	}
	
	/**
	 * @return string
	 */
	public function getUserAgent()
	{
		return $this->userAgent;
	}
	
	/**
	 * @return string
	 */
	public function getTemplateFile()
	{
		return $this->templateFile;
	}
	
	/**
	 * @return string
	 */
	public function getSitemapPath()
	{
		return $this->sitemapPath;
	}
	
	/**
	 * @return string
	 */
	public function getSitemapTemplateFile()
	{
		return $this->sitemapTemplateFile;
	}
	
	/**
	 * @return string
	 */
	public function getErrorTemplateFile()
	{
		return $this->errorTemplateFile;
	}
}
