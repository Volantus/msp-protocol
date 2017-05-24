<?php
namespace Volantus\MSPProtocol\Src\Serial;

/**
 * Class SerialInterface
 *
 * @package Volantus\MSPProtocol\Src\Serial
 */
class SerialInterface
{
    /**
     * @var resource
     */
    private $fileResource;

    /**
     * SerialInterface constructor.
     *
     * @param string $endpoint
     * @param int    $baudRate
     */
    public function __construct(string $endpoint = '/dev/ttyUSB0', int $baudRate = 115200)
    {
        exec("/bin/stty -F $endpoint $baudRate sane raw cs8 hupcl cread clocal -echo -onlcr ");
        $this->fileResource = fopen("/dev/ttyUSB0","c+");

        if (!$this->fileResource) {
            throw new \RuntimeException('Unable to open serial interface ' . $endpoint);
        }
    }

    /**
     * @param string $data
     */
    public function send(string $data)
    {
        stream_set_blocking($this->fileResource, 1);
        fwrite($this->fileResource, $data);
        stream_set_blocking($this->fileResource, 0);
    }

    /**
     * @return string|bool
     */
    public function readByte()
    {
        return fgetc($this->fileResource);
    }
}