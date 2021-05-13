# Iniciando con el API

## Instalación

### Pre-requisitos
- PHP 7.4
- Servidor Web apache o nginx
- MongoDB Atlas  
- Extensión de MongoDB para php habilitada
- [Composer](https://getcomposer.org/download/)

> Estos comandos se ejecutan en la consola de comandos.

### Clonar el código de este repositorio usando git
- `git clone https://github.com/leandroaroca/payloads.git`

### Instalar dependencias

- `composer install`

### Duplicar archivo .env.example con el nombre .env 

- `cp .env.example .env`

### Generar el app_key con el comando 

- `php artisan key:generate`

### Configurar conexión a la base de datos en el archivo .env

**Reemplazar:**

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=laravel

DB_USERNAME=root

DB_PASSWORD=

**Por:**

DB_CONNECTION=mongodb

DB_DATABASE=_DB_

DB_DSN=mongodb+srv://_USR_:_PWD_@cluster0.7lofe.mongodb.net/_DB_?retryWrites=true&w=majority

- Cambiar _USR_ por el usuario de su base de datos mongodb

- Cambiar _PWD_ por la contraseña correspondiente a su usuario.

- Cambiar _DB_ por su colección o base da datos

### Generar las colecciones base 

- `php artisan migrate`

### Instalar passport

- `php artisan passport:install`

> Ignorar advertencias después de ejecutar comando

### Generar secrets

- `php artisan passport:client --password --name="API" --provider="users"`

En el documento `oauth_clients` (mongodb), se creo un registro en su `name` con el valor `API`

Usar `_id` como `client_id`

Usar `secret` como `client_secret`

> Ignorar advertencias después de ejecutar comando

## Usuarios

Para interactuar con las funcionalidades debes tener un usuario registrado y autenticado.

### Crear Usuario

Para crear un usuario ejecutamos el comando:

- `php artisan user:make`

Solicitará nombre, email y contraseña.

## Autenticación

### Credenciales de Aplicación

Cada aplicación que pretenda interactuar con el API debe estar autorizada, se debe solicitar las credenciales de acceso como **Aplicación**.

En las credenciales de acceso tendrás:

- `client_id` : Identificador del cliente
- `client_secret` : Llave secreta del cliente

Estas credenciales se requerirán en el proceso de autenticación. 

> Se generaron en el paso [Generar secrets](#generar-secrets)

### Generar Token de Usuario

La autenticación de usuarios sigue el estándar definido de autenticación [Oauth 2.0](https://tools.ietf.org/html/rfc6749).

Para la autenticación de un usuario se debe usar el `grant_type` tipo `password`

Para solicitar tokens de usuario debes contar con las credenciales de autenticación de aplicación `client_id` y `client_secret`

Con los datos requeridos, debes consumir el endpoint `/oauth/token`

Con el token generado, después puedes hacer peticiones enviando ese mismo token como un encabezado de autenticación

```
Authorization: Bearer {TOKEN}
```

Donde {TOKEN} es retornado por el recurso.

### Indice de recursos

> No requiere autorización (Bearer {TOKEN})


```
GET /api/index
```

# Configuración (supuestos)

Se permite configurar el parámetro donde llega las localizaciones y su separador en caso de ser varias. Esto con el fin de brindar flexibilidad en la definición de la carga de payload.

Para ello se debe modificar `app/payload.php`, este contiene 2 configuraciones `param_name` y `separator`

## Enviar localización (payload)

Aquí se describe las configuraciones posibles del aplicativo para recibir el payload.

### Sin nombre de parámetro, ni separador
Configuración:
```
<?php
return [
    'param_name' => null,
    'separator' => null,
];
```

> Esta configuración permite registrar solo una localización individual.

Ejemplo:
```
POST /api/payload
226c6174223d3e2d32342e3235362c20226c6e67223d3e2d36392e303539362c22
66726f6d223d3e2267773031222c226f726967696e223d3e22494d45493a333533
353439303931303134393638222c2261646472657373223d3e22556e6e616d6564
20526f61642c20416e746f666167617374612c204368696c6522
```

### Sin nombre de parámetro, con separador (recomendada, por defecto)
Configuración:
```
<?php
return [
    'param_name' => null,
    'separator' => PHP_EOL.PHP_EOL,
];
```

> Esta configuración permite registrar una localización individual o varias separadas por saltos de línea.

Ejemplos:

- Individual
```
POST /api/payload
226c6174223d3e2d32342e3235362c20226c6e67223d3e2d36392e303539362c22
66726f6d223d3e2267773031222c226f726967696e223d3e22494d45493a333533
353439303931303134393638222c2261646472657373223d3e22556e6e616d6564
20526f61642c20416e746f666167617374612c204368696c6522
```

- Multiples
```
POST /api/payload
226c6174223d3e2d32342e3235362c20226c6e67223d3e2d36392e303539362c22
66726f6d223d3e2267773031222c226f726967696e223d3e22494d45493a333533
353439303931303134393638222c2261646472657373223d3e22556e6e616d6564
20526f61642c20416e746f666167617374612c204368696c6522

20226c6174223d3e2d33332e33393139392c226c6e67223d3e2d37302e35353732
352c2266726f6d223d3e2267773032222c226f726967696e223d3e22494d45493a
333533343639303931303134303936222c2261646472657373223d3e2253616e20
6d617274696e20383430302c20436f6c696e612c204368696c6522

226c6174223d3e2d33362e33393131312c226c6e67223d3e2d37302e3536323638
2c2266726f6d223d3e2267773031222c226f726967696e223d3e22494d45493a35
3239393837323031323538393531222c2261646472657373223d3e22506174696f
20312c20416e746f6661676173746122

226c6174223d3e2d33332e33393139392c226c6e67223d3e2d37302e3535373235
2c2266726f6d223d3e2267773035222c226f726967696e223d3e22494d45493a34
3934373934313135323633333436222c2261646472657373223d3e22436572726f
20656c20706c6f6d6f20353933312c204c617320436f6e64657322

226c6174223d3e2d33352e33393132322c226c6e67223d3e2d37312e3536373235
2c2266726f6d223d3e2267773035222c226f726967696e223d3e22494d45493a33
3030363531323634373433373232222c2261646472657373223d3e224c6f732054
6f706163696f73203537332c20416e746f6661676173746122
```

### Con nombre de parámetro
Configuración:
```
<?php
return [
    'param_name' => 'localization,
    'separator' => null,
];
```

> Esta configuración permite registrar una localización individual o varias. 
> 
> El parámetro `separator` es ignorado.

Ejemplo individual:

- JSON 
```
POST /api/payload
{
  "localization" : "226c6174223d3e2d32342e3235362c20226c6e67223d3e2d36392e303539362c22
66726f6d223d3e2267773031222c226f726967696e223d3e22494d45493a333533
353439303931303134393638222c2261646472657373223d3e22556e6e616d6564
20526f61642c20416e746f666167617374612c204368696c6522"
}
```

- Form Data
```
POST /api/payload
localization: "226c6174223d3e2d32342e3235362c20226c6e67223d3e2d36392e303539362c22
66726f6d223d3e2267773031222c226f726967696e223d3e22494d45493a333533
353439303931303134393638222c2261646472657373223d3e22556e6e616d6564
20526f61642c20416e746f666167617374612c204368696c6522"
```

Ejemplo multiple:
```
POST /api/payload
{
    "localization": [
        "226c6174223d3e2d32342e3235362c20226c6e67223d3e2d36392e303539362c2266726f6d223d3e2267773031222c226f726967696e223d3e22494d45493a333533353439303931303134393638222c2261646472657373223d3e22556e6e616d656420526f61642c20416e746f666167617374612c204368696c6522",
        "20226c6174223d3e2d33332e33393139392c226c6e67223d3e2d37302e35353732352c2266726f6d223d3e2267773032222c226f726967696e223d3e22494d45493a333533343639303931303134303936222c2261646472657373223d3e2253616e206d617274696e20383430302c20436f6c696e612c204368696c6522"
    ]
}
```

- Form Data
```
POST /api/payload
localization[0]: "226c6174223d3e2d32342e3235362c20226c6e67223d3e2d36392e303539362c22
66726f6d223d3e2267773031222c226f726967696e223d3e22494d45493a333533
353439303931303134393638222c2261646472657373223d3e22556e6e616d6564
20526f61642c20416e746f666167617374612c204368696c6522"

localization[1]: "20226c6174223d3e2d33332e33393139392c226c6e67223d3e2d37302e35353732
352c2266726f6d223d3e2267773032222c226f726967696e223d3e22494d45493a
333533343639303931303134303936222c2261646472657373223d3e2253616e20
6d617274696e20383430302c20436f6c696e612c204368696c6522"
```
# Postman

En la carpeta `Postman` se incluyen 2 archivos para cargar el proyecto y realizar pruebas al api.

`Payload.postman_collection` usar para importar proyecto.
`dev.postman_environment` usar para importar el entorno

# Estructura básica de directorios

- `routes` 

Aquí se almacenan las rutas http, el api usa el archivo `api.php`

- `app`

Aquí se almacenan los archivos de la aplicación que contienen la lógica.

`Domain` => Contiene los dominios de aplicación

`Http` => Contiene todos los recursos Http [Controladores, resources, FormRequest]
