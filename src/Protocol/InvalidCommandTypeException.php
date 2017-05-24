<?php
namespace Volantus\MSPProtocol\Src\Protocol;

/**
 * Class InvalidMspCommandTypeException
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
class InvalidCommandTypeException extends \RuntimeException
{
    /**
     * InvalidMspCommandTypeException constructor.
     *
     * @param int $type
     */
    public function __construct(int $type)
    {
        parent::__construct('Unable to create Protocol response object for unknown type ' . $type);
    }
}