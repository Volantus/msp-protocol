<?php
namespace Volantus\MSPProtocol\Tests\Protocol\Response;

use Volantus\MSPProtocol\Src\Protocol\Response\Attitude;

/**
 * Class AttitudeTest
 *
 * @package Volantus\MSPProtocol\Tests\Protocol\Response
 */
class AttitudeTest extends \PHPUnit_Framework_TestCase
{
    public function test_constructor_payloadEvaluatedCorrectly()
    {
        $payload = pack('s*', -1500, 500, 100);
        $motorStatus = new Attitude($payload);

        self::assertEquals(-1500, $motorStatus->getXAngle());
        self::assertEquals(500, $motorStatus->getYAngle());
        self::assertEquals(100, $motorStatus->getHeading());
    }
}