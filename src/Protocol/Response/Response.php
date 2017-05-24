<?php
namespace Volantus\MSPProtocol\Src\Protocol\Response;

use Volantus\MSPProtocol\Src\Protocol\Package;

/**
 * Class Response
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
class Response extends Package
{
    /**
     * Response constructor.
     *
     * @param int $type
     * @param int $size
     */
    public function __construct(int $type, int $size)
    {
        parent::__construct($type, self::DIRECTION_FROM_FC, $size);
    }

    /**
     * @return string
     */
    public static function getPreamble(): string
    {
        return iconv("UTF-8", "CP437", '$M' . self::DIRECTION_FROM_FC);
    }
}