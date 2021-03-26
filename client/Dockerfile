FROM node:14-alpine3.10 AS builder

WORKDIR /srv

ARG NODE_ENV=production

COPY . .

RUN npm install --prod && npm run build

FROM node:14-alpine3.10 AS app

RUN chown node:node /srv

WORKDIR /srv

USER node

COPY --chown=node:node --from=builder /srv/__sapper__ __sapper__
COPY --chown=node:node --from=builder /srv/static static
COPY --chown=node:node --from=builder /srv/node_modules node_modules

CMD node __sapper__/build

EXPOSE 3000
