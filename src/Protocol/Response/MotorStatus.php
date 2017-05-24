<?php
namespace Volantus\MSPProtocol\Src\Protocol\Response;

/**
 * Class MotorStatus
 *
 * @package Volantus\MSPProtocol\Src\Protocol\Response
 */
class MotorStatus extends Response
{
    const TYPE = 104;

    /**
     * @var int[]
     */
    private $statuses = [];

    /**
     * MotorStatus constructor.
     *
     * @param string $payload
     */
    public function __construct(string $payload)
    {
        parent::__construct(self::TYPE, 32);
        $this->statuses = unpack('S*', $payload);
        $this->statuses = array_values($this->statuses);
    }

    /**
     * @return int[]
     */
    public function getStatuses(): array
    {
        return $this->statuses;
    }
}