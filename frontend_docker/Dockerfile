FROM node:16 as build-stage
WORKDIR /app
COPY ./package*.json ./
RUN npm install
COPY ./ .
RUN npm run build

FROM nginx as production-stage
EXPOSE 3000
COPY ./frontend_docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=build-stage /app/frontend/dist /app