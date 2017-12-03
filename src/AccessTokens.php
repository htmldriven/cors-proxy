<?php

namespace HtmlDriven\CorsProxy;

use HtmlDriven\CorsProxy\Exception\FileNotFoundException;

/**
 * Represents access tokens list.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class AccessTokens
{
    /** @var string[] */
    private $accessTokens = [];

    /**
     * @param string[]
     */
    public function __construct(array $accessTokens)
    {
        $this->accessTokens = $accessTokens;
    }

    /**
     * @return string[]
     */
    public function getAll()
    {
        return $this->accessTokens;
    }

    /**
     * Checks whether specified IP is considered blacklisted.
     *
     * @param string
     * @return bool
     */
    public function isAccessTokenValid($accessToken)
    {
        return in_array($accessToken, $this->accessTokens, true);
    }

    /**
     * Creates new AccessTokens using content of access tokens file.
     * This file must be simple text (one access token per line).
     *
     * @param string
     * @return static
     * @throws FileNotFoundException
     */
    public static function loadFromFile($filepath)
    {
        Helpers::checkFileExists($filepath);

        return new static(
            file(
                $filepath,
                FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
            )
        );
    }
}
