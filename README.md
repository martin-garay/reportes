# Reportes
Reportes en Toba

# Instalacion en proyecto existente

Cargar el entorno de toba del proyecto al que vamos a agregar el proyecto "Reportes"
```
source entorno_toba.env
```
Clonar el proyecto en la ubicacion deseada 
```
git clone https://github.com/laacademia/reportes.git reportes
cd reportes
toba proyecto cargar -p reportes -d `pwd`
```

## Configuracion
* En proyecto.ini configurar la varible `proyecto_usuarios` con el identificador del proyecto del cual vamos a consultar usuarios y perfiles para dar permisos a los reportes. Por defecto es el proyecto "reportes"
```
[proyecto]
proyecto_usuarios = miproyecto
```

* Configurar las fuentes de datos desde el toba editor. Por defecto existe reportes(que es la que guarda los metadatos de los reportes) y negocio que es la base sobre la que se va a consultar.

* Correr el  script `sql/estructura/tablas.sql` para la creacion de las tablas. 

Opcionalmente usar el siguiente comando.
```
export PATH_REPORTES=`pwd`
toba base ejecutar_sql -a $PATH_REPORTES/sql/estructura/tablas.sql -d "$TOBA_INSTANCIA reportes reportes"
```
