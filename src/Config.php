<?php

namespace HtmlDriven\CorsProxy;

use HtmlDriven\CorsProxy\Exception\FileNotFoundException;

/**
 * Application configuration.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class Config
{
    /** @var boolean */
    private $enabled;

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

    /** @var array */
    private $databaseConfig;

    /** @var boolean */
    private $requestLogEnabled;

    /**
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @param array
     * @throws FileNotFoundException If template/sitemap/error file does not exist.
     */
    public function __construct(
        $enabled,
        $urlParameterName,
        $userAgent,
        $templateFile,
        $sitemapPath,
        $sitemapTemplateFile,
        $errorTemplateFile,
        $databaseConfig,
        $requestLogEnabled
    ) {

        Helpers::checkFileExists($templateFile);
        Helpers::checkFileExists($sitemapTemplateFile);
        Helpers::checkFileExists($errorTemplateFile);

        $this->enabled = (bool) $enabled;
        $this->urlParameterName = $urlParameterName;
        $this->userAgent = $userAgent;
        $this->templateFile = $templateFile;
        $this->sitemapPath = $sitemapPath;
        $this->sitemapTemplateFile = $sitemapTemplateFile;
        $this->errorTemplateFile = $errorTemplateFile;
        $this->databaseConfig = $databaseConfig;
        $this->requestLogEnabled = $requestLogEnabled;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
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

    /**
     * @return array
     */
    public function getDatabaseConfig()
    {
        return $this->databaseConfig;
    }

    /**
     * @return boolean
     */
    public function isRequestLogEnabled()
    {
        return $this->requestLogEnabled;
    }
}
