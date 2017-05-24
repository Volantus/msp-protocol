<?php
namespace Volantus\MSPProtocol\Src\Protocol;

/**
 * Class InvalidCRCException
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
class InvalidCRCException extends \RuntimeException
{
    /**
     * InvalidCRCException constructor.
     *
     * @param string $expected
     * @param string $actual
     * @param string $completeMessage
     */
    public function __construct(string $expected, string $actual, string $completeMessage)
    {
        parent::__construct('Received CRC ' . bin2hex($actual) . ' does not match expected ' . bin2hex($expected) . '. Complete message: ' . bin2hex($completeMessage));
    }
}