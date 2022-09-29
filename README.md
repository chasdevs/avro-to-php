# Avro to PHP

Compile Avro .avsc files into usable PHP classes.

Supports PHP >=8.1, for PHP 7.4 support use version 3.1.0

### Installation
```bash
composer require chasdevs/avro-to-php
```

### Usage
```bash
vendor/bin/avro-to-php compile dir/with/avsc/
```

### Releasing
1. Update VER in Makefile
1. Run `make release`

### Roadmap

- [x] Basic Records
- [x] Arrays
- [x] Unions
- [x] CLI
- [x] Defaults
- [x] Enums
- [x] Logical types (only tested with timestamp-millis)
- [x] Maps
- [x] Serialization Tests
- [ ] Fixed
- [ ] Sort Order
- [ ] Aliases
