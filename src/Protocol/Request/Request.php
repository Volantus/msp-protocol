<?php
namespace Volantus\MSPProtocol\Src\Protocol\Request;

use Volantus\MSPProtocol\Src\Protocol\CrcCalculator;
use Volantus\MSPProtocol\Src\Protocol\Package;

/**
 * Class Request
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
abstract class Request extends Package
{
    /**
     * Timeout in seconds waiting for response (including socket reading)
     *
     * @var float
     */
    protected $timeout = 0.1;

    /**
     * Request constructor.
     *
     * @param int $type
     * @param int $size
     */
    public function __construct(int $type, int $size)
    {
        parent::__construct($type, self::DIRECTION_TO_FC, $size);
    }

    /**
     * @return string
     */
    abstract protected function calculatePayload(): string;

    /**
     * @return string
     */
    public function encode(): string
    {
        $payload = $this->calculatePayload();
        $size = pack('C', $this->size);
        $type = pack('C', $this->type);
        $crc = CrcCalculator::calculate($this->type, $this->size, $payload);

        return iconv("UTF-8", "CP437", '$M' . $this->direction) . $size . $type . $payload . $crc;
    }

    /**
     * @return float
     */
    public function getTimeout(): float
    {
        return $this->timeout;
    }

    /**
     * @param float $timeout Timeout in seconds
     */
    public function setTimeout(float $timeout)
    {
        $this->timeout = $timeout;
    }
}