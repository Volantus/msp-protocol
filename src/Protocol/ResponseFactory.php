<?php
namespace Volantus\MSPProtocol\Src\Protocol;

use Volantus\MSPProtocol\Src\Protocol\Response\MotorStatus;
use Volantus\MSPProtocol\Src\Protocol\Response\Response;

/**
 * Class ResponseFactory
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
class ResponseFactory
{
    /**
     * @var
     */
    private $expectedPreamble;

    public function __construct()
    {
        $this->expectedPreamble = Response::getPreamble();
    }

    /**
     * @param string $data
     *
     * @return Response
     */
    public function create(string $data): Response
    {
        $header = unpack('C2', substr($data, 3, 2));
        $size = $header[1];
        $type = $header[2];
        $payload = substr($data, 5, $size);
        $this->validateCrc($payload, $data);

        switch ($type) {
            case MotorStatus::TYPE:
                return new MotorStatus($payload);
            default:
                throw new InvalidCommandTypeException($type);
        }
    }

    /**
     * @param string $payload
     * @param string $completeMessage
     */
    private function validateCrc(string $payload, string $completeMessage)
    {
        $expected = CrcCalculator::calculate(substr($completeMessage, 4, 1), substr($completeMessage, 3, 1), $payload);
        $actual = substr($completeMessage, -1);

        if ($expected != $actual) {
            throw new InvalidCRCException($expected, $actual, $completeMessage);
        }
    }
}