FROM mongo:latest

ENV MONGO_INITDB_ROOT_USERNAME root
ENV MONGO_INITDB_ROOT_PASSWORD root
ENV MONGO_INITDB_DATABASE crud

ADD ./mongodb/init-mongo.js /docker-entrypoint-initdb.d/