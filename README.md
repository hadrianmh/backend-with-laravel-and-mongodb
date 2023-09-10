# Backend with Laravel 8, MongoDB, and JWT Auth

### Registry from Docker Hub
```
docker pull hadrianmh/backend-with-laravel-and-mongodb_server:1.0.0
```

```
docker pull hadrianmh/backend-with-laravel-and-mongodb_database:1.0.0
```

create docker-compose.yml
```
version: '3.9'

services:
  database:
    container_name: database
    image: hadrianmh/backend-with-laravel-and-mongodb_database:1.0.0
    ports:
      - 27017:27017
    volumes:
      - mongodb-data:/data/db

  server:
    container_name: server
    image: hadrianmh/backend-with-laravel-and-mongodb_server:1.0.0
    ports:
      - 8081:80

volumes:
  mongodb-data:
```

```
docker compose up
```

### Manual setup
```
git clone https://github.com/hadrianmh/backend-with-laravel-and-mongodb.git
```

```
docker compose build
```

```
docker compose up
```
