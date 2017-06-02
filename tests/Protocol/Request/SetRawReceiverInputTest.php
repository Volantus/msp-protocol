<?php
namespace Volantus\MSPProtocol\Src\Protocol\Request;

/**
 * Class SetRawReceiverInputTest
 *
 * @package Volantus\MSPProtocol\Src\Protocol\Request
 */
class SetRawReceiverInputTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct_channelsFilledCorrectly()
    {
        $request = new SetRawReceiverInput([1 => 1100, 5 => 1500]);
        self::assertEquals([
                0  => 1000,
                1  => 1100,
                2  => 1000,
                3  => 1000,
                4  => 1000,
                5  => 1500,
                6  => 1000,
                7  => 1000,
                8  => 1000,
                9  => 1000,
                10 => 1000,
                11 => 1000,
                12 => 1000,
                13 => 1000,
                14 => 1000,
                15 => 1000
        ], $request->getChannels());
    }

    public function test_encode_correct()
    {
        $request = new SetRawReceiverInput([1 => 1100, 5 => 1500]);
        self::assertEquals(hex2bin('244d3c20c8e8034c04e803e803e803dc05e803e803e803e803e803e803e803e803e803e80379'), $request->encode());
    }
}