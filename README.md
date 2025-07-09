# Sistema de Propuestas Municipales - Puerto Barrios

Sistema web para la gestión de propuestas ciudadanas para mejorar el municipio de Puerto Barrios.

## 🚀 Características

- ✅ **Gestión de Propuestas** - Crear, ver y gestionar propuestas ciudadanas
- ✅ **Sistema de Roles** - Administradores y usuarios regulares
- ✅ **Estados de Propuestas** - Pendiente, Aprobada, Rechazada
- ✅ **Reportes Estadísticos** - Gráficos y análisis detallados
- ✅ **Categorías Dinámicas** - Organización por temas
- ✅ **Subida de Imágenes** - Soporte para fotos en propuestas
- ✅ **Interfaz Responsive** - AdminLTE con Bootstrap

## 👥 Usuarios de Prueba

### Administrador
- **Email**: admin@propuestas.com
- **Contraseña**: admin123
- **Permisos**: Gestión completa del sistema

### Usuario Regular
- **Email**: amigo@propuestas.com
- **Contraseña**: amigo123
- **Permisos**: Crear y ver sus propias propuestas

## 🛠️ Tecnologías

- **Laravel 11** - Framework PHP
- **MySQL** - Base de datos
- **AdminLTE 3** - Interfaz de administración
- **Chart.js** - Gráficos estadísticos
- **Bootstrap 4** - Framework CSS
- **DataTables** - Tablas interactivas

## 📊 Funcionalidades

### Para Usuarios
- Crear propuestas con descripción e imágenes
- Ver estado de sus propuestas
- Crear nuevas categorías
- Dashboard personalizado

### Para Administradores
- Aprobar/rechazar propuestas
- Ver todas las propuestas del sistema
- Gestionar usuarios y roles
- Reportes estadísticos completos
- Análisis por categorías y estados

## 🚀 Instalación

1. Clonar repositorio
2. `composer install`
3. Configurar `.env`
4. `php artisan migrate`
5. `php artisan db:seed --class=DemoSeeder`
6. `php artisan serve`

## 📈 Reportes

El sistema incluye reportes detallados con:
- Estadísticas por categoría
- Gráficos de estados
- Análisis temporal
- Propuestas detalladas con descripciones

---
Desarrollado para mejorar la participación ciudadana en Puerto Barrios 🇬🇹