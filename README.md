ArrayUtils
==========

Install
-------

```bash
composer require gupalo/arrayutils
```


Features
--------

All code is covered by tests. Look at tests to understand better how it's working.

All methods are static.

Items can be iterable (array, \Generator, ...) of one of:
* array
* object with public properties or getters (anything Symfony PropertyAccessor can get) 


## ArrayAggregator

* `max(items, field)`: max field value among items
* `sum(items, field)`: sum of field values of items
* `ratio(items, field, field2`: `"sum by field"/"sum by field2"`
* `maxRatio(items, field, field2)`: max among `"field value"/"field value2"`


## ArrayComparer

Comparing is smart - if compared values are float, they are rounded with precision = 8.

* `compareOne(a1, a2, keys)`:
   check that each `(string)a1[key] === (string)a2[key]` for each of keys.
   returns "patch" how to go from a1 to a2. `null` value means that we need to unset this key. 
* `compare(a1, a2, keys)`
   a1 and a2 are expected to be array of arrays.
   returns patch how what's changed in a2 compared to a1 - array with keys:
   * `created`: which items should be created and their values
   * `updated`: which items should be updated and updated fields
   * `removed`: which items (ids) should be deleted
* `compareFlat(a1, a2)`
   similar to `compare` but a1 and a2 are considered scalars and are compared fully, not by fields


## ArrayFactory

* `createKeys(keys, value)`: create array with these keys and value
* `createDictionary(a, keyColumn, valueColumn)`:
  similar to `array_column(a, valueColumn, keyColumn)` but doesn't require values present in all items (`?? null`)


## ArrayKeysHelper

* `index($a, array|string $keys = 'id')`: create indexed array where index may contain several fields
* `indexAndGroup($a, array|string $keys = 'id')`: create indexed array but allow several items with same index
* `fill($a, $keys, $defaultValue = null)`: ensure that all keys exist in array and all others are missing
* `filter($a, $keys, $createMissingKeys = true)`: get these keys from array
* `unset($a, $keys)`: unset these keys from each array item


## ArrayRandom

* `pick(array $items)`: select random value from array
* `pickMultiple(array $items, int $count = 1, bool $preserveKeys = false, mixed $default = [])`:
  select multiple ($count) random values from array


## ArrayTable

* `arrayToKeyValues(array $data)`: covert table (like TSV; first item is header with keys) to array with named keys


## ArrayUniquer

* `values(array $a)`: uniq -> values
* `notNullValues(array $a)`: filter not null -> uniq -> values
* `columnValues(array $a, string $column)`: column -> uniq -> values
* `mergeValues(...$a)`: merge -> uniq -> values
* `mergeNotNullValues(...$a)`: merge -> filter not null -> uniq -> values


## FloatArrayFactory

* `createPreserveKeys(array $a)`: ensure that all values are float
* `create(array $a)`: ensure that all values are float -> values


## IntArrayFactory

* `createPreserveKeys(array $a)`: ensure that all values are int
* `create(array $a)`: ensure that all values are int -> values
