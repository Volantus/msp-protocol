<?php
namespace Volantus\MSPProtocol\Src\Protocol\Request;

use Volantus\MSPProtocol\Src\Protocol\Response\Attitude as AttitudeResponse;

/**
 * Class Attitude
 *
 * @package Volantus\MSPProtocol\Src\Protocol\Request
 */
class Attitude extends EmptyRequest
{
    public function __construct()
    {
        parent::__construct(AttitudeResponse::TYPE);
    }
}