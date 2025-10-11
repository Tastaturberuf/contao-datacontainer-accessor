# WIP

## Unset properties

To ensure a consistent experience, use `->unset($key)` instead of the core PHP `unset()`.

This ensures the data is properly unset. The regular `unset()` function does not work with property hooks; it only works with dynamic properties.

