# DataContainerAccessor

To initialize a new instance of `DataContainerAccessor` use the constructor or the static `create` method.

```php
$dca = new DataContainerAccessor('tl_example');
$dca = DataContainerAccessor::create('tl_example');
```

## Properties and Methods

### Config

`$GLOBALS['TL_DCA']['tl_example']['config']`

Get and set `config` properties directly.

```php
$dca->config->enableVersioning = true;
$dca->config->notEditable = true;

if ($dca->config->enableVersioning) {
    // ...
}
```

```php
$dca->config = function ($config, $table) {
    $config->enableVersioning = true;
    $config->notEditable = true;
};
```

```php

// closure
$dca->config(function(Config $config, string $table): void {
    $config->enableVersioning = true;
    $config->notEditable = true;
    
    if ($config->enableVersioning) {
        // ...
    }
});
```

Set new ConfigInterface class instance:

```php
$dca->config = new Config(); // must be instance of ConfigInterface
```
