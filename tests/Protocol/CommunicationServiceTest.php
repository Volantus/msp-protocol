<?php
namespace Volantus\MSPProtocol\Tests\Protocol;

use Volantus\MSPProtocol\Src\Protocol\CommunicationService;
use Volantus\MSPProtocol\Src\Protocol\CrcCalculator;
use Volantus\MSPProtocol\Src\Protocol\Request\MotorStatus;
use Volantus\MSPProtocol\Src\Protocol\Request\Request;
use Volantus\MSPProtocol\Src\Protocol\Response\Response;
use Volantus\MSPProtocol\Src\Protocol\ResponseFactory;
use Volantus\MSPProtocol\Src\Protocol\TimeoutException;
use Volantus\MSPProtocol\Src\Serial\SerialInterface;

/**
 * Class CommunicationServiceTest
 *
 * @package Volantus\MSPProtocol\Tests\Protocol
 */
class CommunicationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $responseFactory;

    /**
     * @var SerialInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $serialInterface;

    /**
     * @var CommunicationService
     */
    private $service;

    protected function setUp()
    {
        $this->responseFactory = $this->getMockBuilder(ResponseFactory::class)->disableOriginalConstructor()->getMock();
        $this->serialInterface = $this->getMockBuilder(SerialInterface::class)->disableOriginalConstructor()->getMock();
        $this->service = new CommunicationService($this->serialInterface, $this->responseFactory);
    }

    public function test_send_messageSendCorrectly()
    {
        $request = new MotorStatus();
        $request->setTimeout(0);
        $this->serialInterface->method('readByte')->willReturn(false);

        $this->serialInterface->expects(self::once())
            ->method('send')
            ->with(self::equalTo($request->encode()));

        try {
            $this->service->send($request);
        } catch (TimeoutException $e) {}
    }

    public function test_send_timeout_correctTime()
    {
        $request = new MotorStatus();
        $request->setTimeout(0.1);
        $this->serialInterface->method('readByte')->willReturn(false);

        $start = microtime(true);
        try {
            $this->service->send($request);
        } catch (TimeoutException $e) {}
        $end = microtime(true);
        $delta = $end - $start;

        self::assertGreaterThan(0.1, $delta);
        self::assertLessThan(0.2, $delta);
    }

    /**
     * @expectedException \Volantus\MSPProtocol\Src\Protocol\TimeoutException
     * @expectedExceptionMessage Unable to receive response within 0.01 seconds. (Received data: <>)
     */
    public function test_send_timeout_exception()
    {
        $request = new MotorStatus();
        $request->setTimeout(0.01);
        $this->serialInterface->method('readByte')->willReturn(false);

        $this->service->send($request);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Invalid preamble WWW received. Expected: $M>
     */
    public function test_send_timeout_wrongPreamble_exceptionThrown()
    {
        $request = new MotorStatus();
        $this->serialInterface->method('readByte')->willReturn('W');

        $this->service->send($request);
    }

    public function test_send_dataInterpretedCorrectly()
    {
        $payload = pack('S', 1000);
        $crc = CrcCalculator::calculate(pack('C', 99), pack('C', 2), $payload);
        $data = Response::getPreamble() . pack('C', 2) . pack('C', 99) . $payload . $crc;
        $dataBytes = str_split($data);

        $request = new MotorStatus();
        $expectedResponse = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $this->serialInterface->method('readByte')->willReturn($dataBytes[0], $dataBytes[1], $dataBytes[2], $dataBytes[3], $dataBytes[4], $dataBytes[5], $dataBytes[6], $dataBytes[7]);

        $this->responseFactory->expects(self::once())
            ->method('create')
            ->with(self::equalTo($data))
            ->willReturn($expectedResponse);

        $response = $this->service->send($request);
        self::assertSame($expectedResponse, $response);
    }
}