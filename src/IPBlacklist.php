<?php

namespace HtmlDriven\CorsProxy;

use HtmlDriven\CorsProxy\Exception\FileNotFoundException;

/**
 * Represents IP Blacklist.
 *
 * @author RebendaJiri <jiri.rebenda@htmldriven.com>
 */
class IPBlacklist
{
    /** @var string[] */
    private $ips = [];

    /**
     * @param string[]
     */
    public function __construct(array $ips)
    {
        $this->ips = $ips;
    }

    /**
     * @return string[]
     */
    public function getIps()
    {
        return $this->ips;
    }

    /**
     * Checks whether specified IP is considered blacklisted.
     *
     * @param string
     * @return bool
     */
    public function isIPBlacklisted($ip)
    {
        return in_array($ip, $this->ips, true);
    }

    /**
     * Creates new IPBlacklist using content of IP blacklist file.
     * This file must be simple text (one IP per line).
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
