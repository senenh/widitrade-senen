# Pureba técnica Widitrade - Acortador de URLs

## Descripción

API construida utilizando el framework Symfony, diseñada para acortar URLs. 

## Tecnologías

-   Docker
-   PHP 8.3 - Symfony 7
-   Git

## Setup

Levantar contenedores Docker:
`docker-compose up -d`

Instalar dependencias:
`docker exec -it widitrade-senen-php-1 composer install`

## Uso

Realizar una petición POST al endpoint `/api/v1/url-shortener` , incluyendo el Header Authorization con el token con el formato descrito en el enunciado del problema y un json que incluya la url a acortar, ejemplo:

```shell

curl --location --request POST 'http://localhost:8099/api/v1/url-shortener' \
--header 'Authorization: Bearer ([]' \
--header 'Content-Type: application/json' \
--data-raw '{
"url": "https://www.google.es/search?sca_esv=3c0cd88929cc7700&q=gatos+en+el+espacio&tbm=isch&source=lnms&sa=X&ved=2ahUKEwivkLnlseyEAxWRUaQEHU9sAgYQ0pQJegQICRAB&biw=1728&bih=959&dpr=2"
}'

```

Ejemplo de respuesta

 HTTP CODE 200
```json
{
    "url": "http://tinyurl.com/y2z3x4"
}
```

## Tests

Para ejecutar los tests, ejecutar el siguiente comando:

`docker exec -it widitrade-senen-php-1 composer test`

## Consideraciones

Desde la versión 6.2 de Symfony se puede usar Access Token Authentication implementado en el componente Security https://symfony.com/doc/6.2/security/access_token.html, pero sólo acepta un string según lo definido en el rfc6750 https://datatracker.ietf.org/doc/html/rfc6750#section-2.1, por lo que he tenido que crear un custom token extractor que acepte los paréntesis, llaves y corchetes como token.


## Roadmap (Plan de Mejoras Futuras)
- Añadir base de datos: Guardar las urls acortadas en base de datos para no tener que realizar la petición a la API de TinyURL cada vez que se quiera acortar una url.
- Añadir cache 
- Guardar tokens con los secrets de symfony. https://symfony.com/doc/current/configuration/secrets.html
- Añadir tests para todos los errores que nos pueda dar TinyUrl



