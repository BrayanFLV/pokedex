 
# Pokémon App
Este proyecto es una aplicación web que permite visualizar información de Pokémon simulando una pokedex consumiendo la API de [PokeAPI](https://pokeapi.co/). La aplicación cuenta con un backend en PHP utilizando Slim Framework y un frontend en React. Además, se ha implementado paginación, búsqueda, almacenamiento en caché y dockerización para facilitar su despliegue.  

## Tecnologías Utilizadas 
El proyecto está compuesto por diferentes tecnologías en el backend y el frontend:

### Backend (PHP - Slim Framework)
- **Slim Framework**: Un microframework ligero para PHP que facilita la creación de API REST.
- **Guzzle HTTP Client**: Utilizado para realizar peticiones HTTP a la API de Pokémon.
- **PostgreSQL**: Base de datos utilizada (aunque en esta implementación no se está almacenando información en la BD).
- **PHP-DI**: Gestión de dependencias en PHP.
- **Symfony Cache**: Implementado para mejorar el rendimiento almacenando respuestas en caché.
- **PHPUnit**: Utilizado para realizar pruebas unitarias del backend.
- **Docker**: Para la contenerización del backend y base de datos.

### Frontend (React)
- **React**: Librería de JavaScript utilizada para construir la interfaz de usuario.
- **React Router**: Para gestionar la navegación entre rutas en la aplicación.
- **Axios**: Librería utilizada para realizar peticiones HTTP al backend.
- **CSS **: Se han aplicado estilos personalizados sin utilizar frameworks como TailwindCSS o Bootstrap.

---

## **Estructura del Proyecto**  
```
Pokemon-App/
│── backend/                # Carpeta del backend
│   ├── public/             # Carpeta pública para acceder desde el navegador
│   │   ├── index.php       # Punto de entrada del backend
│   ├── src/                # Código fuente
│   │   ├── Controllers/    # Controladores de la API
│   │   │   ├── PokemonController.php
│   │   ├── routes.php      # Definición de rutas
│   ├── tests/              # Pruebas unitarias
│   ├── Dockerfile          # Configuración de Docker
│   ├── docker-compose.yml  # Configuración de Docker Compose
│   ├── composer.json       # Dependencias de PHP
│── frontend/               # Carpeta del frontend
│   ├── src/                # Código fuente de React
│   │   ├── components/     # Componentes reutilizables
│   │   ├── pages/          # Páginas de la aplicación
│   │   ├── services/       # Peticiones HTTP con Axios
│   │   ├── styles/         # Archivos CSS
│   ├── public/             # Archivos públicos de React
│   ├── Dockerfile          # Configuración de Docker para el frontend
│   ├── docker-compose.yml  # Configuración de Docker Compose
│   ├── package.json        # Dependencias de Node.js
```

---

## Instalación y Ejecución del Proyecto

### **Ejecutar en Local (Windows/Linux)**

#### ** Backend**
1. Asegúrate de tener PHP 8+ y Composer instalado.
2. Clona el repositorio:
   ```bash
   git clone https://github.com/BrayanFLV/pokemon-app.git
   cd pokemon-app/backend
   ```
3. Instala las dependencias:
   ```bash
   composer install
   ```
4. Ejecuta el servidor PHP:
   ```bash
   php -S localhost:8000 -t public
   ```
5. O simplemete descarga los archivos del proyecto.

#### Frontend
1. Asegúrate de tener Node.js instalado.
2. Navega a la carpeta del frontend:
   ```bash
   cd ../frontend
   ```
3. Instala las dependencias:
   ```bash
   npm install
   ```
4. Inicia la aplicación:
   ```bash
   npm start
   ```
5. La aplicación estará disponible en:  
   http://localhost:3000

---

### Ejecutar con Docker
Para ejecutar el backend y el frontend con Docker, sigue estos pasos:

1. Clona el repositorio y navega a la raíz del proyecto:
   ```bash
   git clone https://github.com/BrayanFLV/pokemon-app.git
   cd pokemon-app
   ```
2. Construye y levanta los contenedores:
   ```bash
   docker-compose up --build
   ```
3. La aplicación estará disponible en:  
   - Backend: http://localhost:8000  
   - Frontend: http://localhost:3000

Para detener los contenedores, usa:
```bash
docker-compose down
```

---

## Rutas de la API (Backend en Slim PHP)
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/pokemon` | Obtiene la lista de Pokémon (paginado) |
| GET | `/pokemon/{identifier}` | Obtiene información de un Pokémon por ID o nombre |
| GET | `/search?name={nombre}` | Busca un Pokémon por nombre |

---

## Pruebas Unitarias
Las pruebas del backend se encuentran en la carpeta `backend/tests/`.

### Ejecutar Pruebas en el Backend
Desde la carpeta del backend:
```bash
vendor/bin/phpunit --testdox
```

Ejemplo de pruebas implementadas:
- Test para obtener un Pokémon existente
- Test para manejar error cuando el Pokémon no existe

---

