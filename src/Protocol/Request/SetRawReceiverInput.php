<?php
namespace Volantus\MSPProtocol\Src\Protocol\Request;

/**
 * Class SetRawReceiverInput
 *
 * @package Volantus\MSPProtocol\Src\Protocol\Request
 */
class SetRawReceiverInput extends Request
{
    const TYPE = 200;

    /**
     * @var array
     */
    private $channels;

    /**
     * SetRawReceiverInput constructor.
     *
     * @param array $channels 16 channels are supported
     *                        (0 => ROLL, 1 => PITCH, 2 => YAW, 3 => THROTTLE, 4 => AUX1, 5 => AUX2 ... 15 => AUX12
     *                        Unset channels are filled up with value 1000
     */
    public function __construct(array $channels)
    {
        parent::__construct(self::TYPE, 32);
        $this->channels = array_fill(0, 16, 1000);
        foreach ($channels as $i => $channel) {
            $this->channels[$i] = $channel;
        }
    }

    /**
     * @return string
     */
    protected function calculatePayload(): string
    {
        return pack('S*', ...$this->channels);
    }

    /**
     * @return array
     */
    public function getChannels(): array
    {
        return $this->channels;
    }
}