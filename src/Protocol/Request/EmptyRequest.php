<?php
namespace Volantus\MSPProtocol\Src\Protocol\Request;

/**
 * Class EmptyRequest
 *
 * @package Volantus\MSPProtocol\Src\Protocol
 */
abstract class EmptyRequest extends Request
{
    /**
     * EmptyRequest constructor.
     *
     * @param int $type
     */
    public function __construct($type)
    {
        parent::__construct($type, 0);
    }

    /**
     * @return string
     */
    protected function calculatePayload(): string
    {
        return '';
    }
}