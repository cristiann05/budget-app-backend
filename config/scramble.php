<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    'api_path' => 'api',

    'api_domain' => null,

    'export_path' => 'api.json',

    'info' => [
        'version' => env('API_VERSION', '1.0.0'),
        'description' => '# 💰 BudgetApp API

REST API para gestión de presupuestos personales. Construida con **Laravel 11** y **Sanctum**.

## Autenticación
Usa **Bearer Token**. Consigue tu token en `/api/login` o `/api/register` y pégalo en el botón **Authorize** de arriba.

## Roles
| Rol | Valor | Descripción |
|-----|-------|-------------|
| Admin | 1 | Acceso total al sistema |
| User | 2 | Acceso solo a sus propios datos |

## Rate Limiting
| Ruta | Límite |
|------|--------|
| `/api/register` y `/api/login` | 5 peticiones/minuto |
| Resto de rutas | 60 peticiones/minuto |

## Recursos
| Recurso | Descripción |
|---------|-------------|
| **Auth** | Registro, login y logout |
| **Users** | Gestión de usuarios (Admin) |
| **Categories** | Categorías de gasto personalizadas |
| **Budgets** | Presupuestos mensuales |
| **Allocations** | Asignación de presupuesto por categoría |
| **Expenses** | Registro de gastos reales |',
    ],

    'ui' => [
        'title' => '💰 BudgetApp API',
        'theme' => 'dark',
        'hide_try_it' => false,
        'hide_schemas' => false,
        'logo' => '',
        'try_it_credentials_policy' => 'include',
        'layout' => 'responsive',
    ],

    'servers' => null,

    'enum_cases_description_strategy' => 'description',

    'enum_cases_names_strategy' => false,

    'flatten_deep_query_parameters' => true,

    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],
];
