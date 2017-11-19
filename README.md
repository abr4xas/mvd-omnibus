### Ómnibus 

> Pequeña librería para consultar las rutas, horarios y paradas de ómnibus en Montevideo.


### instalación

Primero, [`composer`](https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md)

Luego agrega lo siguiente a tu archivo `composer.json`

```json
"require": {
    "abr4xas/omnibus": "dev-master"
}
```

Y posteriormente:

```bash
$ composer update
$ composer dump-autoload -o // opcional
```


### como usar

```php
use Omnibus\Omnibus;
```

...