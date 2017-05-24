<?php
namespace Volantus\MSPProtocol\Src\Protocol;

/**
 * Class Package
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
abstract class Package
{
    const DIRECTION_FROM_FC = '>';
    const DIRECTION_TO_FC   = '<';

    /**
     * @var int
     */
    protected $type;

    /**
     * @var string
     */
    protected $direction;

    /**
     * Payload size in $bytes;
     *
     * @var
     */
    protected $size;

    /**
     * Package constructor.
     *
     * @param int    $type
     * @param string $direction
     * @param        $size
     */
    public function __construct(int $type, string $direction, int $size)
    {
        $this->type = $type;
        $this->direction = $direction;
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }
}