<?php
namespace Volantus\MSPProtocol\Src\Protocol;

/**
 * Class CrcCalculator
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
final class CrcCalculator
{
    private function __construct()
    {
    }

    /**
     * @param string $type
     * @param string $size
     * @param string $payload
     *
     * @return string
     */
    public static function calculate(string $type, string $size, string $payload): string
    {
        $crc = $type ^ $size;

        if (!empty($payload)) {
            foreach (str_split($payload) as $payloadByte) {
                $crc = $crc ^ $payloadByte;
            }
        }

        return $crc;
    }
}