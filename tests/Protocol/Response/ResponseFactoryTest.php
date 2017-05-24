<?php
namespace Volantus\MSPProtocol\Tests\MSP\Response;

use Volantus\MSPProtocol\Src\Protocol\CrcCalculator;
use Volantus\MSPProtocol\Src\Protocol\Response\MotorStatus;
use Volantus\MSPProtocol\Src\Protocol\Response\Response;
use Volantus\MSPProtocol\Src\Protocol\ResponseFactory;

/**
 * Class ResponseFactoryTest
 *
 * @package Volantus\MSPProtocol\Tests\Protocol\Response
 */
class ResponseFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new ResponseFactory();
    }

    /**
     * @expectedException \Volantus\MSPProtocol\Src\Protocol\InvalidCRCException
     * @expectedExceptionMessage Received CRC 0a does not match expected 8a. Complete message: 244d3e0263e8030a
     */
    public function test_create_invalidCrc()
    {
        $payload = pack('S*', 1000);
        $data = Response::getPreamble().pack('C*', 2, 99) . $payload . pack('C', 10);
        $this->factory->create($data);
    }

    /**
     * @expectedException \Volantus\MSPProtocol\Src\Protocol\InvalidCommandTypeException
     * @expectedExceptionMessage Unable to create Protocol response object for unknown type 99
     */
    public function test_create_unknownType()
    {
        $payload = pack('S*', 1000);
        $crc = CrcCalculator::calculate(pack('C', 99), pack('C', 2), $payload);
        $data = Response::getPreamble().pack('C*', 2, 99) . $payload . $crc;
        $this->factory->create($data);
    }

    public function test_create_motorStatusCorrect()
    {
        $payload = pack('S*', 1000, 1050, 1100, 1150, 1200, 1250, 1300, 1350, 1400, 1450, 1500, 1550, 1600, 1650, 1700, 1750);
        $crc = CrcCalculator::calculate(pack('C', MotorStatus::TYPE), pack('C', 32), $payload);
        $data = Response::getPreamble().pack('C*', 32, MotorStatus::TYPE) . $payload . $crc;
        /** @var MotorStatus $response */
        $response = $this->factory->create($data);

        self::assertInstanceOf(MotorStatus::class, $response);
        self::assertCount(16, $response->getStatuses());
        self::assertEquals(1000, $response->getStatuses()[0]);
        self::assertEquals(1750, $response->getStatuses()[15]);
    }


}