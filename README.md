# WIP

## Unset properties

To ensure a consistent experience, use `->unset($key)` instead of the core PHP `unset()`.

This ensures the data is properly unset. The regular `unset()` function does not work with property hooks; it only works
with dynamic properties.

## No `list` key

There is no `list` key anymore just use sorting, label, operations without it.

## todos

- [ ] Rebuild to __construct(parentElemtent); Use ::create() for userspace.
- [ ] Check field creation
- [ ] Check callback handling
- [ ] Check palette handling
- [ ] Check SQL handling in config and fields
- [ ] Check Operations
- [ ] Check order for ::create parameters and allow callback
- [ ] Check __invoke(): self
- [ ] Narrow boolean properties to without `null`?

## Ideas

with the new ansatz it makes sense to use the fluid methods more:

complicated

```php
Label::create($table)(function ($label) {
    $label->fields = [StoreModel::name];
    $label->showColumns = true;
});
```

better:

```php
Label::create($table)
    ->fields(StoreModel::name)
    ->showColumns()
;
```

---

- try things with invoke().

- try syntax like
  ```php
  Label::create($table)->set(function(Label $label) {
    $label->dies = 'das';
  });
  ```

- try to build field from code templates, so you can define bool fields and reuse this quickly in the closure. quasi
  preset the closure param.
    ```php
    $dca->fields->add(CategoryModel::defaultMarker, function (BoolenField $field) {
        $field->sql = 'binary(16) NULL';
    }, BoolenField::class);
    ```
    - Nest step is reflect the closure and set the needed Fieldtype und dont need ->add anymore
    - So we can Build FileTree types eg.