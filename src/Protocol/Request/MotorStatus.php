<?php
namespace Volantus\MSPProtocol\Src\Protocol\Request;

use Volantus\MSPProtocol\Src\Protocol\Response\MotorStatus as MotorStatusResponse;

/**
 * Class MotorStatus
 *
 * @package Volantus\MSPProtocol\Src\Protocol\Request
 */
class MotorStatus extends EmptyRequest
{
    public function __construct()
    {
        parent::__construct(MotorStatusResponse::TYPE);
    }
}