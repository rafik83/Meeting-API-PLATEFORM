FROM node:14-alpine3.10 AS build

WORKDIR /opt/app

ARG NODE_ENV=production

USER node
COPY --chown=node:node . .

RUN npm install --production && npm run build

CMD npm run start

EXPOSE 3000
