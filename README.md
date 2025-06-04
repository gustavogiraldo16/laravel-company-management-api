# Gestión de Empresas API con Laravel

Este proyecto implementa una API RESTful para la gestión de empresas, siguiendo los requerimientos de un desafío técnico. Permite realizar operaciones CRUD sobre datos de empresas, con validaciones, manejo de excepciones robusto y una interfaz de usuario básica.

---

## 📚 Tabla de Contenidos

1. [Requisitos del Sistema](#1-🛠-requisitos-del-sistema)
2. [Instalación y Configuración](#2-⚙-instalación-y-configuración)
3. [Ejecución del Servidor](#3-▶-ejecución-del-servidor)
4. [Acceso a la API](#4-🌐-acceso-a-la-api)
5. [Documentación de la API (Swagger UI)](#5-📄-documentación-de-la-api-swagger-ui) **Pendiente Implementación**
6. [Frontend Básico](#6-🖥-frontend-básico) **Pendiente Implementación**
7. [Ejecución de Pruebas](#7-✅-ejecución-de-pruebas)
8. [Integración Continua (CI/CD)](#8-🔁-integración-continua-cicd) **Pendiente Implementación**
9. [Estructura del Proyecto y Patrones](#9-🧱-estructura-del-proyecto-y-patrones)
10. [Licencia](#10-📝-licencia)

---

## 1. 🛠 Requisitos del Sistema

- PHP ^8.3
- Composer ^2.8
- Node.js & NPM/Yarn (opcional)
- Servidor Web: Nginx, Apache o PHP Development Server
- Base de datos: MySQL, SQLite (por defecto para pruebas)

---

## 2. ⚙ Instalación y Configuración

### 2.1 Clonar el Repositorio

```bash
git clone https://github.com/gustavogiraldo16/laravel-company-management-api.git
cd laravel-company-management-api.git
```

### 2.2 Instalar Dependencias

```bash
composer install
```

### 2.3 Configuración del Entorno

```bash
cp .env.example .env
php artisan key:generate
```

Por defecto se usa SQLite. Si prefieres otra base de datos, modifica las siguientes variables en `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

### 2.4 Ejecutar Migraciones

```bash
php artisan migrate
```

Para reiniciar la base de datos:

```bash
php artisan migrate:fresh
```

---

## 3. ▶ Ejecución del Servidor

Inicia el servidor con:

```bash
php artisan serve
```

Disponible en: `http://127.0.0.1:8000`

---

## 4. 🌐 Acceso a la API

### Base URL

```
http://127.0.0.1:8000/api/v1
```

### Endpoints

| Método | Endpoint               | Descripción                            |
|--------|------------------------|----------------------------------------|
| GET    | /companies             | Obtener todas las empresas             |
| GET    | /companies/{nit}       | Obtener una empresa por su NIT         |
| POST   | /companies             | Crear una nueva empresa                |
| PUT    | /companies/{nit}       | Actualizar una empresa                 |
| DELETE | /companies/{nit}       | Eliminar empresa (solo si está inactiva)|

**Ejemplo de Request Body:**

```json
// POST
{
  "nit": "123456789-0",
  "name": "Ejemplo S.A.S.",
  "address": "Calle 1",
  "phone": "3001234567"
}

// PUT
{
  "name": "Ejemplo Actualizado",
  "address": "Calle 2",
  "status": "inactive"
}
```

### Lógica de Negocio

- `nit` es único y no editable.
- `status` por defecto es `active`.
- Solo se puede eliminar si `status` es `inactive`.

### Respuestas

```json
// Éxito
{
  "status": "success",
  "message": "Company created successfully",
  "data": { ... }
}

// Error 404
{
  "status": "error",
  "message": "Resource not found."
}

// Error 422
{
  "status": "error",
  "message": "The given data was invalid.",
  "errors": {
    "campo": ["Mensaje de error"]
  }
}

// Error 403
{
  "status": "error",
  "message": "Only companies with "inactive" status can be deleted"
}

// Error 500
{
  "status": "error",
  "message": "An unexpected error occurred."
}
```

---

## 5. 📄 Documentación de la API (Swagger UI)

> ⚠️ **Nota:**
> Esta sesión aún no está implementada y se encuentra en construcción.
> Por favor, ten en cuenta que la funcionalidad descrita aquí puede estar incompleta o sujeta a cambios.

Disponible en:
`http://127.0.0.1:8000/api/documentation`

Generar documentación después de cambios:

```bash
php artisan l5-swagger:generate
```

---

## 6. 🖥 Frontend Básico

> ⚠️ **Nota:**
> La sección de frontend básico aún no está implementada y se encuentra en construcción.
> Próximamente se añadirá la lógica y documentación detallada para esta funcionalidad.

Interfaz incluida en:

```
http://127.0.0.1:8000/companies-app
```

Permite:

- Listar empresas
- Crear, editar, eliminar (solo inactivas)

---

## 7. ✅ Ejecución de Pruebas

El siguiente comando ejecuta **todas las pruebas** (unitarias y de integración) del proyecto:

```bash
php artisan test
```

### 7.1 Pruebas Unitarias

Ejecuta solo las pruebas unitarias con:

```bash
php artisan test --testsuite=Unit
```

### 7.2 Pruebas de Integración

Ejecuta solo las pruebas de integración con:

```bash
php artisan test --testsuite=Feature
```

---

## 8. 🔁 Integración Continua (CI/CD)

> ⚠️ **Nota:**
> La sección de integración continua (CI/CD) aún no está implementada y se encuentra en construcción.
> Próximamente se añadirá la configuración y documentación detallada para esta funcionalidad.

---

## 9. 🧱 Estructura del Proyecto y Patrones

- **API RESTful**: Implementada en `api.php` y controladores bajo `Controllers`, expone endpoints para CRUD de empresas, retornando respuestas en formato JSON.
- **Service Layer**: Toda la lógica de negocio relacionada con empresas está centralizada en `App\Services\CompanyService`.
- **Form Requests**: Las validaciones de entrada se gestionan mediante clases personalizadas en `Requests`, asegurando datos correctos antes de llegar a los controladores.

---

## 10. 📝 Licencia

MIT License.
Desarrollado por: **Gustavo Adolfo Giraldo Rendón**
Fecha: **2025-06-04**
