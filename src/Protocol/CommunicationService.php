<?php
namespace Volantus\MSPProtocol\Src\Protocol;

use Volantus\MSPProtocol\Src\Protocol\Request\Request;
use Volantus\MSPProtocol\Src\Protocol\Response\Response;
use Volantus\MSPProtocol\Src\Serial\SerialInterface;

/**
 * Class CommunicationService
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
class CommunicationService
{
    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var SerialInterface
     */
    private $serialInterface;

    /**
     * @var string
     */
    private $expectedPreamble;

    /**
     * Sleep time between serial interface read attempts (in microseconds)
     *
     * @var int
     */
    private $sleepTime = 1000;

    /**
     * CommunicationService constructor.
     *
     * @param SerialInterface|null $serialInterface
     * @param ResponseFactory|null $responseFactory
     */
    public function __construct(SerialInterface $serialInterface = null, ResponseFactory $responseFactory = null)
    {
        $this->serialInterface = $serialInterface ?: new SerialInterface();
        $this->responseFactory = $responseFactory ?: new ResponseFactory();
        $this->expectedPreamble = Response::getPreamble();
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function send(Request $request): Response
    {
        $this->serialInterface->send($request->encode());
        return $this->receiveResponse($request->getTimeout());
    }

    /**
     * @param float $timeout
     *
     * @return Response
     */
    private function receiveResponse(float $timeout): Response
    {
        $start = microtime(true);
        $data = '';
        $size = null;

        do {
            $nextByte = $this->serialInterface->readByte();

            if ($nextByte !== false) {
                $data .= $nextByte;
                $dataLength = strlen($data);

                if ($dataLength == 3 && $data !== $this->expectedPreamble) {
                    throw new \RuntimeException('Invalid preamble ' . $data . ' received. Expected: ' . $this->expectedPreamble);
                } elseif ($dataLength == 4) {
                    $size = unpack('C', $nextByte)[1];
                } elseif ($size != null && $dataLength >= ($size + 6)) {
                    return $this->responseFactory->create($data);
                }
            } else {
                usleep($this->sleepTime);
            }
        } while ((microtime(true) - $start) <= $timeout);

        throw new TimeoutException('Unable to receive response within ' . $timeout . ' seconds. (Received data: <' . $data . '>)');
    }

    /**
     * @param int $sleepTime
     */
    public function setSleepTime(int $sleepTime)
    {
        $this->sleepTime = $sleepTime;
    }
}