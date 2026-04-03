# `Config::class`

The table configuration describes the table itself, e.g. which type of data container stores the data or how it
relates to other tables. You can also enable versioning or define what happens to child records when data is edited or
deleted.

## How to instantiate `Config`

```php
# contao/dca/tl_example.php

use Tastaturberuf\ContaoDataContainerAccessor\Config;
use Tastaturberuf\ContaoDataContainerAccessor\DataContainerAccessor;

$config = new Config('tl_example');

$config = Config::create('tl_example');

$config = new DataContainerAccessor('tl_example')->config;

$config = DataContainerAccessor::create('tl_example')->config;
```

Why is there a static `Config::create()` method? Because PHP does not allow writing to a property on a temporary
expression.
So if you want a one-liner, `Config::create()` is the preferred option.

```php
// Fatal error: Cannot use temporary expression in write context
new Config('tl_example')->enableVersioning = false;

// This will work
Config::create('tl_example')->enableVersioning = false;
```

## Properties and methods

Properties are virtual property hooks and type-safe. For each property, there is a method with a default parameter and,
in some cases, additional convenience parameters.

**The methods are always fluid and you can chain them together if you like.**

```php
// @todo test for references support and nicer syntax
$config->label = 'sdsdsd';
$config->label();
```

```php
$config->ptable = 'tl_parent';
$config->ptable('tl_parent');
```

```php
$config->dynamicPtable = true;
$config->dynamicPtable(); // default parameter is true
$config->dynamicPtable(false); // Use false to disable it
```

### ctable

#### Property `array $ctable`

For reordering, prepending, or appending, array unpacking is straightforward. Or use `array_merge()` if you are
unfamiliar with array unpacking.

Read more about array unpacking: https://www.php.net/manual/en/language.types.array.php#language.types.array.unpacking

```php
$config->ctable; // returns always an array

$config->ctable = ['tl_child']; // has to be an array because you can have more child tables
$config->ctable = 'tl_child';   // casts to array ['tl_child']
$config->ctable = []; // unset child tables

// merge with existing tables
$config->ctable = array_merge(['tl_first'], $config->ctable, ['tl_content']);
// same with array unpacking
$config->ctable = ['tl_first', ...$config->ctable, 'tl_content'];
```

#### Method `ctable(string|array $table = [], ...string $tables): Config`

```php
$config->ctable('tl_child');                        // set one
$config->ctable('tl_child', 'tl_content', 'tl_foo');  // set as many as you need
$config->ctable();                                    // unset

$config->ctable($config->ctable, 'tl_last');                  // append one table
$config->ctable(['tl_first', ...$config->ctable, 'tl_last']); // merge manually if you want to prepend and append
```

### dataContainer

#### Property `?string $dataContainer`

```php
$config->dataContainer = DC_Table::class;
$config->dataContainer = DC_Folder::class;
$config->dataContainer = DC_File::class;

$config->dataContainer = null; // throws InvalidArgumentException
```

#### Method `dataContainer(string $class = 'Contao\DC_Table'): Config`

```php
$config->dataContainer(); // set to DC_Table, most used case
$config->dataContainer(DC_Folder::class);
$config->dataContainer(DC_File::class);
```

### markAsCopy

#### Property `null|string $markAsCopy = null`

```php
$config->markAsCopy = 'title';
$config->markAsCopy = null; 
```

#### Method `markAsCopy(null|string $field = null): Config`

```php
$config->markAsCopy('title');
$config->markAsCopy(); // set to null as default
```

### uploadPath

#### Property `null|string $uploadPath = null`

```php
$config->uploadPath = '/path';
$config->uploadPath = null; 
```

#### Method `uploadPath(?string $path = null): Config`

```php
$config->uploadPath('/path');
$config->uploadPath(); // set to null as default
```

### validFileTypes

#### Property `?string $validFileTypes = null`

```php
$config->validFileTypes = 'jpeg,jpg,jif';
$config->validFileTypes = ['jpeg', 'jpeg', 'jif'];
$config->validFileTypes = null;
```

#### Method `validFileTypes(null|string|array $extensions = null): Config`

```php
$config->validFileTypes('jpeg,jpg,jif');
$config->validFileTypes(['jpeg', 'jpg', 'jif']);
$config->validFileTypes();  // reset because null is default value
```

### editableFileTypes

#### Property `?string $editableFileTypes = null`

```php
$config->editableFileTypes = 'txt,php,js';
$config->editableFileTypes = ['txt', 'php', 'js'];
$config->editableFileTypes = null;
```

#### Method `editableFileTypes(null|string|array $extensions = null): Config`

```php
$config->editableFileTypes('txt,php,js');
$config->editableFileTypes(['txt', 'php', 'js']);
$config->editableFileTypes(); // reset because null is default value
```

### databaseAssisted

#### Property `?bool $databaseAssisted = null`

```php
$config->databaseAssisted = true;
$config->databaseAssisted = false;
$config->databaseAssisted = null;
```

#### Method `databaseAssisted(bool $enabled = true): Config`

```php
$config->databaseAssisted(); // true
$config->databaseAssisted(false);
```

---

### closed

#### Property `?bool $closed = null`

```php
$config->closed = true;
$config->closed = false;
$config->closed = null;
```

#### Method `closed(bool $enabled = true): Config`

```php
$config->closed(); // true
$config->closed(false);
```

---

### notEditable

#### Property `?bool $notEditable = null`

```php
$config->notEditable = true;
$config->notEditable = false;
$config->notEditable = null;
```

#### Method `notEditable(bool $enabled = true): Config`

```php
$config->notEditable(); // true
$config->notEditable(false);
```

---

### notDeletable

#### Property `?bool $notDeletable = null`

```php
$config->notDeletable = true;
$config->notDeletable = false;
$config->notDeletable = null;
```

#### Method `notDeletable(bool $enabled = true): Config`

```php
$config->notDeletable(); // true
$config->notDeletable(false);
```

---

### notSortable

#### Property `?bool $notSortable = null`

```php
$config->notSortable = true;
$config->notSortable = false;
$config->notSortable = null;
```

#### Method `notSortable(bool $enabled = true): Config`

```php
$config->notSortable(); // true
$config->notSortable(false);
```

---

### notCopyable

#### Property `?bool $notCopyable = null`

```php
$config->notCopyable = true;
$config->notCopyable = false;
$config->notCopyable = null;
```

#### Method `notCopyable(bool $enabled = true): Config`

```php
$config->notCopyable(); // true
$config->notCopyable(false);
```

---

### notCreatable

#### Property `?bool $notCreatable = null`

```php
$config->notCreatable = true;
$config->notCreatable = false;
$config->notCreatable = null;
```

#### Method `notCreatable(bool $enabled = true): Config`

```php
$config->notCreatable(); // true
$config->notCreatable(false);
```

---

### switchToEdit

#### Property `?bool $switchToEdit = null`

```php
$config->switchToEdit = true;
$config->switchToEdit = false;
$config->switchToEdit = null;
```

#### Method `switchToEdit(bool $enabled = true): Config`

```php
$config->switchToEdit(); // true
$config->switchToEdit(false);
```

---

### enableVersioning

#### Property `?bool $enableVersioning = null`

```php
$config->enableVersioning = true;
$config->enableVersioning = false;
$config->enableVersioning = null;
```

#### Method `enableVersioning(bool $enabled = true): Config`

```php
$config->enableVersioning(); // true
$config->enableVersioning(false);
```

---

### hideVersionMenu

#### Property `?bool $hideVersionMenu = null`

```php
$config->hideVersionMenu = true;
$config->hideVersionMenu = false;
$config->hideVersionMenu = null;
```

#### Method `hideVersionMenu(bool $enabled = true): Config`

```php
$config->hideVersionMenu(); // true
$config->hideVersionMenu(false);
```

---

### doNotCopyRecords

#### Property `?bool $doNotCopyRecords = null`

```php
$config->doNotCopyRecords = true;
$config->doNotCopyRecords = false;
$config->doNotCopyRecords = null;
```

#### Method `doNotCopyRecords(bool $enabled = true): Config`

```php
$config->doNotCopyRecords(); // true
$config->doNotCopyRecords(false);
```

---

### doNotDeleteRecords

#### Property `?bool $doNotDeleteRecords = null`

```php
$config->doNotDeleteRecords = true;
$config->doNotDeleteRecords = false;
$config->doNotDeleteRecords = null;
```

#### Method `doNotDeleteRecords(bool $enabled = true): Config`

```php
$config->doNotDeleteRecords(); // true
$config->doNotDeleteRecords(false);
```

---

### backlink

#### Property `?string $backlink = null`

```php
$config->backlink = 'do=news';
$config->backlink = null;
```

#### Method `backlink(?string $query = null): Config`

```php
$config->backlink('do=news');
$config->backlink(); // reset: default null
```

---

### backendSearchIgnore

Since Contao 5.7

#### Property `?bool $backendSearchIgnore = null`

```php
$config->backendSearchIgnore = true;
$config->backendSearchIgnore = false;
$config->backendSearchIgnore = null;
```

#### Method `backendSearchIgnore(bool $enabled = true): Config`

```php
$config->backendSearchIgnore(); // true
$config->backendSearchIgnore(false);
```

---

TODO

---

## Examples

### Default PHP array syntax

```php
// contao/dca/tl_example.php

use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_example']['config'] = [
    'dataContainer' => DC_Table::class,
    'enableVersioning' => true,
    'sql' => [
        'keys' => [
            'id' => 'primary',
        ],
    ],
];
```

### Properties

Properties are type-safe and easy to learn. Use the regular DCA syntax and map it to properties.

```php
// contao/dca/tl_example.php

use Contao\DC_Table;
use Tastaturberuf\ContaoDataContainerAccessor\Config;

$config = new Config('tl_example');

// or

$config = Config::create('tl_example');

$config->dataContainer = DC_Table::class;
$config->enableVersioning = true;
$config->sql->keys->id = 'primary';
```

### Fluid

With property hooks, you may repeat `$config->...` many times. To reduce that, use the fluent methods. Many methods
have practical defaults and some allow changing multiple related values.

```php
// contao/dca/tl_example.php

use Tastaturberuf\ContaoDataContainerAccessor\DataContainerAccessor;

$dca = new DataContainerAccessor('tl_example')
    ->config
        ->dataContainer()            // default is Contao\DC_Table::class
        ->enableVersioning()         // default true
        ->sql->keys->id = 'primary'
;
```
