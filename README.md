# AaxisTest
El siguiente proyecto responde a las consignas solicitadas en el Challenge.

## Especificaciones
| Techs |       |       |      |      |
| :-------- | :------- | :------- | :------- | :------- |
| Requisitos |`PHP 7.4`| `PostgreSQL` | `Composer`|  `Apache`  |
| Opcionales | `Symfony CLI` | `XAMPP` | `Docker` |      |

Nota: En caso de usar Docker, ya está todo considerado.
## Instalación

Mediante Docker ejecutar

```bash
  docker-compose up -d
```
* Crear una base de datos en PostgreSQL y nombrarla `localDB`.
* Configurar los datos de `.env` para conectar a tu base de datos.
* Ejecutar las migraciones de Symfony mediante el comando:

```bash
  php bin/console doctrine:migration:migrate
```


## Documentación
La API implementa un controllador llamado ProductsController el cual tiene las responsabilidad de
* Listar todos los productos
* Crear productos
* Actualizar productos

### Estructura:

El código fuente se organiza de la siguiente manera:

1. Controllers:

* ProductsController

2. Contracts

* AbstracBaseController (clase abstracta que agrega funcionalidad comun a controladores)

3. Servicios & Seguridad:

* Logger (captura excepciones del servidor para posteriormente corregirlas).
* Validator (validaciones generales de acceso. Ej: Token).

### Desarrollo 

Con respecto al flujo de desarrollo, se deja adjunto un archivo llamado GIT-FLOW que explica el flujo para que un desarrollo pase a Producción.
## API Reference
En el repositorio está adjunta la colección de POSTMAN junto con datos de muestra. 

Notas: 
* Puede que sea necesario configurar la variable de entorno que guarda la ruta de la API en tu entorno local. (Ej: Con docker sería localhost:800/public/index.php)
* Tener en cuenta que se necesari una TOKEN de acceso. Por cuestiones practicas, se deja el token de acceso:

```http
  eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
```
De todas formas, la colección de postman adjuntada está configurada con éste token.

A continuación podrás ver los endpoinsts disponibles:

#### #getAll
Obtiene todos los registros.

```http
  GET /products
```

| Parameter | Type     |Auth|
| :-------- | :------- |:------- |
| `none` |  |Token|


#### #createProduct
Crea uno o más productos.

```http
  POST /products
```

| Parameter | Type     |Auth|
| :-------- | :------- |:------- |
| `payload` | `JSON`  |Token|


#### #updateProduct
Actualiza uno o más productos.

```http
  PUT /products
```

| Parameter | Type     |Auth|
| :-------- | :------- |:------- |
| `payload` | `JSON`  |Token|


## Authors

- [@jorgeemilianom](https://github.com/jorgeemilianom)


## FAQ

#### ¿Problemas para acceder a la API en local?

Es posible que debas apuntar a tu localhost agregando al path `/public/index.php`.

#### La colección de Postman no funciona.

Asegurate de haber configurado la variable de entorno `{{URL_ENDPOINT}}` con la URL que corresponda 

#### Composer install me arroja errores

Posiblemente se deba a la falta de alguna librería en tu sistema. Sin embargo, por la simpleza del proyecto, podemos prescindir de ellas ejecutando:
```bash
composer install --ignore-platform-reqs
```




