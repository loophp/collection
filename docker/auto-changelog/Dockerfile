FROM node:15.4.0-alpine

ENV SRC_PATH /src

RUN apk add --no-cache git
RUN npm install -g auto-changelog@2.2.1
RUN mkdir -p $SRC_PATH

VOLUME [ "$SRC_PATH" ]
WORKDIR $SRC_PATH

CMD ["--help"]
ENTRYPOINT ["auto-changelog"]
