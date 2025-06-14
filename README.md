
# 📚 Librería Químera

**Librería Químera** es una plataforma web que permite a los usuarios registrarse, iniciar sesión, subir libros en texto, leer los libros de otros usuarios y dejar comentarios. Está desarrollada en PHP, con MySQL como base de datos, y desplegada mediante Docker y Docker Compose.

---

## 🚀 Tecnologías utilizadas

- **Frontend**: HTML, CSS (estilo medieval personalizado)
- **Backend**: PHP 8.2
- **Base de datos**: MySQL 8
- **Contenedores**: Docker + Docker Compose
- **CI/CD**: GitHub Actions
- **Control de versiones**: Git + GitHub

---

## 📦 Requisitos previos

Antes de ejecutar el proyecto, necesitas tener instalado:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/)
- Git (opcional, pero recomendable)

---

## 🛠️ Instalación y ejecución

1. **Clonar el repositorio**

```bash
git clone https://github.com/tu-usuario/libreria-quimera.git
cd libreria-quimera
```

2. **Levantar el entorno**

```bash
docker compose up --build
```

3. Accede a la aplicación desde tu navegador:

```
http://localhost:8282
```

---

## 🧱 Estructura del proyecto

```
libreria-quimera/
├── backend/                  # Código PHP y frontend
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   ├── libros.php
│   ├── upload.php
│   ├── leer.php             # Página de lectura + comentarios
│   ├── logout.php
│   ├── config.php
│   └── css/style.css
├── db/
│   └── init.sql              # Script de creación de tablas
├── images/                   # Logo e imágenes usadas
├── docker-compose.yml
├── Dockerfile (en backend/)
└── .github/workflows/ci.yml
```

---

## 👤 Usuarios y roles

Actualmente todos los usuarios tienen el mismo rol. El sistema permite:

- Registrar nuevos usuarios
- Iniciar sesión
- Subir libros en texto o manualmente
- Leer libros de otros usuarios
- Comentar libros desde `leer.php`

---

## 🗄️ Estructura de la base de datos

El proyecto crea automáticamente las siguientes tablas:

- `usuarios(id, nombre, email, password)`
- `libros(id, titulo, contenido, imagen, usuario_id, fecha_subida)`
- `comentarios(id, libro_id, usuario_id, contenido, fecha)`

Si quieres verlas desde consola:

```bash
docker exec -it db mysql -u root -p
```

Luego:

```sql
USE libreria;
SHOW TABLES;
```

---

## ⚙️ Automatización (CI/CD)

Cada vez que se hace `push` a la rama `main`, GitHub Actions:

- Valida el archivo `docker-compose.yml`
- Construye el contenedor del backend
- Lanza los servicios temporalmente para comprobar su estado
- Finaliza automáticamente

Ver en la pestaña **Actions** del repositorio.

---

## 📝 Notas

- El logo se encuentra en `/images/logoquimera.png`
- Se usa una textura medieval como fondo (`old-wall.png`)
- El sistema está pensado para funcionar en **local**
- No incluye cifrado HTTPS ni despliegue externo (por ahora)

---

## 📷 Capturas (opcional)

- 📖 Página principal con último libro subido
- 📥 Formulario de subida de libros
- 🔐 Login y registro de usuarios
- 💬 Comentarios en los libros

---

## 📜 Licencia

Este proyecto ha sido desarrollado como Trabajo Fin de Grado. Puedes adaptarlo y ampliarlo libremente para fines educativos.

---

## ✍️ Autor

**José María Rodríguez Acedo**  
Grado Superior en Administración de Sistemas Informáticos en Red (ASIR)
