<?php
namespace Volantus\MSPProtocol\Src\Protocol\Response;

/**
 * Class Attitude
 *
 * @package Volantus\MSPProtocol\Src\Protocol\Response
 */
class Attitude extends Response
{
    const TYPE = 108;

    /**
     * @var int
     */
    private $xAngle;

    /**
     * @var int
     */
    private $yAngle;

    /**
     * @var int
     */
    private $heading;

    /**
     * Attitude constructor.
     *
     * @param string $payload
     */
    public function __construct(string $payload)
    {
        parent::__construct(self::TYPE, 6);

        $data = unpack('s*', $payload);
        $this->xAngle = $data[1];
        $this->yAngle = $data[2];
        $this->heading = $data[3];
    }

    /**
     * @return int
     */
    public function getXAngle(): int
    {
        return $this->xAngle;
    }

    /**
     * @return int
     */
    public function getYAngle(): int
    {
        return $this->yAngle;
    }

    /**
     * @return int
     */
    public function getHeading(): int
    {
        return $this->heading;
    }
}