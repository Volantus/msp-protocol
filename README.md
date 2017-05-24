# MSP Protocol in PHP
A PHP implementation of the MSP (serial multiwii) protocol

## Usage
Complete device communication is handled by CommunicationService, which gets a SerialInterface injected.

```PHP
    use Volantus\MSPProtocol\Src\Protocol\CommunicationService;
    use Volantus\MSPProtocol\Src\Protocol\Request\MotorStatus as MotorStatusRequest;
    use Volantus\MSPProtocol\Src\Protocol\Response\MotorStatus as MotorStatusResponse;
    use Volantus\MSPProtocol\Src\Serial\SerialInterface;
    
    $serialInterface = new SerialInterface('/dev/ttyUSB0', 115200);
    $service = new CommunicationService($serialInterface);
    
    /** @var MotorStatusResponse $response */
    $response = $service->send(new MotorStatusRequest());
    
    // Status of the first motor (Value between 1000 and 2000)
    $response->getStatuses()[0];
```

## Requests/Response
> The current request/response implementation set is not complete yet
> Especially custom packages from Clean-/Betaflight are missing yet
> Contributors are highly welcome.

All request and responses are encapsulated into objects, which includes interpretation logic about their respective payload structure.
* Request namespace: Volantus\MSPProtocol\Src\Protocol\Request
* Response namespace: Volantus\MSPProtocol\Src\Protocol\Response

For a complete list of available (orginal MultiWii) packages please consult the [official documentation](http://www.multiwii.com/wiki/index.php?title=Multiwii_Serial_Protocol).

## Contribution
Contributors a highly welcome.
Please respect the following basic rules:
### Code style
The project follows the ZEND code style with a extended flexible line size.
### Tests
Please create/extend/modify unit and integration tests.
System dependencies should always be mocked.
### Workflow
1. Fork the repository
2. Create feature branch from master
3. Create pull request