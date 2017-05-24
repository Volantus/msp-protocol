<?php
namespace Volantus\MSPProtocol\Tests\Protocol\Response;

use Volantus\MSPProtocol\Src\Protocol\Response\MotorStatus;

/**
 * Class MotorStatusTest
 *
 * @package Volantus\MSPProtocol\Tests\Protocol\Response
 */
class MotorStatusTest extends \PHPUnit_Framework_TestCase
{
    public function test_constructor_payloadEvaluatedCorrectly()
    {
        $payload = pack('S*', 1000, 1050, 1100, 1150, 1200, 1250, 1300, 1350, 1400, 1450, 1500, 1550, 1600, 1650, 1700, 1750);
        $motorStatus = new MotorStatus($payload);

        self::assertCount(16, $motorStatus->getStatuses());
        self::assertEquals(1000, $motorStatus->getStatuses()[0]);
        self::assertEquals(1050, $motorStatus->getStatuses()[1]);
        self::assertEquals(1100, $motorStatus->getStatuses()[2]);
        self::assertEquals(1150, $motorStatus->getStatuses()[3]);
        self::assertEquals(1200, $motorStatus->getStatuses()[4]);
        self::assertEquals(1250, $motorStatus->getStatuses()[5]);
        self::assertEquals(1300, $motorStatus->getStatuses()[6]);
        self::assertEquals(1350, $motorStatus->getStatuses()[7]);
        self::assertEquals(1400, $motorStatus->getStatuses()[8]);
        self::assertEquals(1450, $motorStatus->getStatuses()[9]);
        self::assertEquals(1500, $motorStatus->getStatuses()[10]);
        self::assertEquals(1550, $motorStatus->getStatuses()[11]);
        self::assertEquals(1600, $motorStatus->getStatuses()[12]);
        self::assertEquals(1650, $motorStatus->getStatuses()[13]);
        self::assertEquals(1700, $motorStatus->getStatuses()[14]);
        self::assertEquals(1750, $motorStatus->getStatuses()[15]);
    }
}