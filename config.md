# Config

To set or access the data container configuration you can use the following two ways.

For shorter one or two line configurations you can use the simple default syntax:

```php
use Tastaturberuf\ContaoDataContainerAccessor\DataContainerAccessor;

$dca = new DataContainerAccessor('tl_test');

$dca->config->ptable = 'tl_parent';
$dca->config->ctable = ['tl_child'];
```

If you want to use more complex configurations you can use the following closure syntax:

```php
use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\DataContainerAccessor;

$dca = new DataContainerAccessor('tl_test');

$dca->config(static function (Config $config): void {
    $config->ptable = 'tl_parent';
    $config->ctable = ['tl_child'];
});
```

Or use a first class callable:

```php
use Tastaturberuf\ContaoDataContainerAccessor\Config;

function setTables(Config $config): void
{
    $config->ptable = 'tl_parent';
    $config->ctable = ['tl_child'];
}

$dca->config(setTables(...));
```

The callable will have the following signature:

```php
function(Config $config, string $field, string $table): void
```

## Dedicated use case

If you want only to change one property, you can instance the config directly and set the property.
This will work because most of the property hooks are virtual and directly manipulate the $GLOBALS array

```php
use Tastaturberuf\ContaoDataContainerAccessor\Config;

// before
$GLOBALS['TL_DCA']['tl_test']['config']['ptable'] = 'tl_parent';

// after
$config = new Config('tl_test');
$config->ptable = 'tl_parent';

// sadly we can't do this syntax
new Config('tl_test')->ptable = 'tl_parent';
// Fatal error: Cannot use temporary expression in write context in ...

// so I make a static helper for a oneliner
Config::for('tl_test')->ptable = 'tl_parent';
```

## Custom properties

You can use any custom properties you want:

```php
use Tastaturberuf\ContaoDataContainerAccessor\Config;

$config = new Config('tl_test');

$config->myCustomProperty = 'myCustomValue';

assert($config->myCustomProperty === 'myCustomValue'); // true
```

## Unset properties

```php
use Tastaturberuf\ContaoDataContainerAccessor\Config;

$config = new Config('tl_test');

$config->myCustomProperty = 'myCustomValue';

unset($config->myCustomProperty);
```

But that doesn't work for virtual property hooks. So the best way is to use `unset` in every situation:

```php
use Tastaturberuf\ContaoDataContainerAccessor\Config;

$config = new Config('tl_test');

$config->ptable = 'tl_parent';

$config->unset('ptable');

// this throws Error: Cannot unset hooked property
unset($config->ptable)
```

