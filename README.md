# 💰 BudgetApp API

> REST API para gestión de presupuestos personales. Controla tus ingresos, categorías de gasto y registra cada euro que sale de tu bolsillo.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Sanctum](https://img.shields.io/badge/Sanctum-Auth-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

---

## ✨ Características

- 🔐 **Autenticación segura** con Laravel Sanctum (tokens con expiración de 24h)
- 📧 **Verificación de email** y **recuperación de contraseña** vía Resend
- 💼 **Gestión de presupuestos** mensuales con opción de recurrencia automática
- 🗂️ **Categorías personalizadas** con colores hex
- 📊 **Asignaciones** de presupuesto por categoría con validación de límite
- 💸 **Registro de gastos** reales por asignación
- 👥 **Roles** de usuario (Admin / User)
- 🛡️ **Policies** en todos los recursos — cada usuario solo accede a sus datos
- ⚡ **Rate limiting** en todas las rutas
- 📖 **Documentación interactiva** con Scramble (Stoplight Elements)
- 🔄 **CORS** configurado para Angular

---

## 🚀 Stack tecnológico

| Tecnología | Uso |
|------------|-----|
| Laravel 11 | Framework backend |
| PHP 8.2 | Lenguaje |
| MySQL 8 | Base de datos |
| Laravel Sanctum | Autenticación con tokens |
| Resend | Envío de emails transaccionales |
| Scramble | Documentación API automática |

---

## 📋 Requisitos

- PHP >= 8.2
- Composer
- MySQL 8
- Cuenta en [Resend](https://resend.com) (gratis)

---

## ⚙️ Instalación

```bash
# Clona el repositorio
git clone https://github.com/cristiann05/budget-app-backend.git
cd budget-app-backend

# Instala dependencias
composer install

# Copia el archivo de entorno
cp .env.example .env

# Genera la clave de la aplicación
php artisan key:generate

# Configura tu base de datos y credenciales en .env
# DB_DATABASE, DB_USERNAME, DB_PASSWORD
# RESEND_API_KEY

# Ejecuta las migraciones
php artisan migrate

# Inicia el servidor
php artisan serve
```

---

## 🔑 Variables de entorno

```env
APP_NAME=BudgetApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=budget_app
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=resend
MAIL_FROM_ADDRESS="noreply@tudominio.com"
RESEND_API_KEY=

API_VERSION=1.0.0
```

---

## 📖 Documentación

Una vez iniciado el servidor, accede a la documentación interactiva en:

```
http://localhost:8000/docs/api
```

---

## 🛣️ Endpoints

### 🔓 Públicos

| Método | Ruta | Descripción |
|--------|------|-------------|
| `POST` | `/api/register` | Registrar usuario |
| `POST` | `/api/login` | Iniciar sesión |
| `POST` | `/api/forgot-password` | Solicitar reset de contraseña |
| `POST` | `/api/reset-password` | Restablecer contraseña |

### 🔐 Autenticados (Bearer Token)

| Método | Ruta | Descripción |
|--------|------|-------------|
| `POST` | `/api/logout` | Cerrar sesión |
| `POST` | `/api/logout-all` | Cerrar sesión en todos los dispositivos |
| `GET` | `/api/email/verify/{id}/{hash}` | Verificar email |
| `POST` | `/api/email/resend` | Reenviar email de verificación |
| `POST` | `/api/account/change-password` | Cambiar contraseña |
| `POST` | `/api/account/change-email` | Cambiar email |
| `DELETE` | `/api/account` | Eliminar cuenta |

### 💼 Recursos (Autenticado + Verificado)

| Método | Ruta | Descripción |
|--------|------|-------------|
| `GET/POST` | `/api/categories` | Listar / Crear categorías |
| `GET/PATCH/DELETE` | `/api/categories/{id}` | Ver / Actualizar / Eliminar categoría |
| `GET/POST` | `/api/budgets` | Listar / Crear presupuestos |
| `GET/PATCH/DELETE` | `/api/budgets/{id}` | Ver / Actualizar / Eliminar presupuesto |
| `GET/POST` | `/api/budgets/{id}/allocations` | Listar / Crear asignaciones |
| `PATCH/DELETE` | `/api/budgets/{id}/allocations/{id}` | Actualizar / Eliminar asignación |
| `GET/POST` | `/api/allocations/{id}/expenses` | Listar / Crear gastos |
| `PATCH/DELETE` | `/api/allocations/{id}/expenses/{id}` | Actualizar / Eliminar gasto |
| `GET` | `/api/users` | Listar usuarios (solo Admin) |
| `GET/PATCH/DELETE` | `/api/users/{id}` | Ver / Actualizar / Eliminar usuario |

---

## 🗄️ Estructura de la base de datos

```
users
├── id, name, email, password, role, email_verified_at

categories
├── id, user_id, name, color

budgets
├── id, user_id, total_amount, month, is_recurring

allocations
├── id, budget_id, category_id, amount

expenses
├── id, allocation_id, description, amount, date
```

---

## 🔒 Seguridad

- Tokens Sanctum con expiración de **24 horas**
- **Rate limiting**: 5 req/min en auth, 60 req/min en el resto
- **Policies** en todos los recursos — nadie accede a datos ajenos
- Validación estricta con **Form Requests** y mensajes en español
- Contraseñas hasheadas con **bcrypt** (12 rounds)
- **Sesiones encriptadas**
- Notificación por email al cambiar contraseña

---

## 👨‍💻 Autor

**Cristian Ayala Sánchez**

[![LinkedIn](https://img.shields.io/badge/LinkedIn-cristian05-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/cristian05/)
[![GitHub](https://img.shields.io/badge/GitHub-cristiann05-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/cristiann05)

---

## 📄 Licencia

MIT
