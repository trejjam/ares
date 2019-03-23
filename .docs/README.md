# Trejjam > Ares

## Content

- [Configuration](#configuration)
- [Services available in DI container](#services-available-in-di-container)
- [Usage](#usage)

## Configuration

You have to register this extension at first.

```yaml
extensions:
    trejjam.ares: Trejjam\Ares\DI\AresExtension
```

List of all options:

```yaml
trejjam.mailchimp:
  mapper: Trejjam\Ares\Mapper::class 
  http:
    clientFactory: null
    client:
      verify: Composer\CaBundle\CaBundle::getSystemCaRootBundlePath()
```

Minimal production configuration:

```yaml
extensions:
    trejjam.ares: Trejjam\Ares\DI\AresExtension
```

## Configuration extra

This extensions is compatible with [contributte/guzzlette](https://github.com/contributte/guzzlette).

Minimal interoperability configuration:

```yaml
extensions:
    trejjam.ares: Trejjam\Ares\DI\AresExtension
    contributte.guzzle: Contributte\Guzzlette\DI\GuzzleExtension

trejjam.ares:
  http:
    clientFactory: @contributte.guzzle.clientFactory::createClient()

contributte.guzzle:
  debug: %debugMode%
```

## Services available in DI container

- [`Trejjam\Ares\Request`](https://github.com/trejjam/ares/blob/master/src/Request.php)  
	This class is supposed to perform http requests through `GuzzleHttp\Client`
- [`Trejjam\Ares\IMapper`](https://github.com/trejjam/ares/blob/master/src/IMapper.php)  
	Interface supposed to map XML response to object, default implemenatation is [`Trejjam\Ares\Mapper`](https://github.com/trejjam/ares/blob/master/src/Mapper.php) 

## Usage

Example user subscribe component

`IcoFactory.php`:
```php
/**
 * @method onError(\Exception $e, string $message)
 */
final class IcoFactory extends Nette\Application\UI\Component
{
	/**
	 * @var Trejjam\Ares\Request
	 */
	private $aresRequest;

	/**
	 * @var callable[]
	 */
	public $onError = [];

	public function __construct(
		Trejjam\Ares\Request $aresRequest
	) {
		parent::__construct();

		$this->aresRequest = $aresRequest;
	}

	protected function createComponentNewsletter()
	{
		$form = new Nette\Application\UI\Form;

		$form->addEmail('ico', 'ico')
			 ->setRequired();

		$form->addSubmit('submit', 'submit');
		$form->onSuccess[] = [$this, 'processIco'];

		return $form;
	}

	public function processIco(Nette\Application\UI\Form $form, \stdClass $values) : void
	{
		try {
			$aresResponse = $this->aresRequest->getResponse($values->ico);
			assert($aresResponse instanceof Trejjam\Ares\Entity\Ares);
		} catch (Trejjam\Ares\IcoNotFoundException $e) {
			$onError($e, 'ID number not found in register');

			return;
		} catch (GuzzleHttp\Exception\BadResponseException $e) {
			$error($e, 'Register is temporary unavailable');

			return;
		}
	}
}
```
