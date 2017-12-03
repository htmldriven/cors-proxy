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

    /** @var string  */
    private $ipBlacklistFile;

    /** @var string  */
    private $accessTokensFile;

    /** @var array */
    private $databaseConfig;

    /**
     * @param string
     * @param string
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
        $urlParameterName,
        $userAgent,
        $templateFile,
        $sitemapPath,
        $sitemapTemplateFile,
        $errorTemplateFile,
        $ipBlacklistFile,
        $accessTokensFile,
        $databaseConfig
    ) {
        Helpers::checkFileExists($templateFile);
        Helpers::checkFileExists($sitemapTemplateFile);
        Helpers::checkFileExists($errorTemplateFile);

        if ($ipBlacklistFile !== null) {
            Helpers::checkFileExists($ipBlacklistFile);
        }
        if ($accessTokensFile !== null) {
            Helpers::checkFileExists($accessTokensFile);
        }

        $this->urlParameterName = $urlParameterName;
        $this->userAgent = $userAgent;
        $this->templateFile = $templateFile;
        $this->sitemapPath = $sitemapPath;
        $this->sitemapTemplateFile = $sitemapTemplateFile;
        $this->errorTemplateFile = $errorTemplateFile;
        $this->ipBlacklistFile = $ipBlacklistFile;
        $this->accessTokensFile = $accessTokensFile;
        $this->databaseConfig = $databaseConfig;
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
     * @return string
     */
    public function getIPBlacklistFile()
    {
        return $this->ipBlacklistFile;
    }

    /**
     * @return string
     */
    public function getAccessTokensFile()
    {
        return $this->accessTokensFile;
    }

    /**
     * @return array
     */
    public function getDatabaseConfig()
    {
        return $this->databaseConfig;
    }
}
