FROM dunglas/frankenphp:1-builder-php8.3 AS builder
COPY --from=caddy:builder /usr/bin/xcaddy /usr/bin/xcaddy

RUN apt-get update && apt-get install --no-install-recommends -y \
    git

ENV CGO_ENABLED=1 XCADDY_SETCAP=1 XCADDY_GO_BUILD_FLAGS="-ldflags \"-w -s -extldflags '-Wl,-z,stack-size=0x80000'\""
RUN xcaddy build \
    --output /usr/local/bin/frankenphp \
    --with github.com/dunglas/frankenphp/caddy \
    --with github.com/dunglas/mercure/caddy \
    --with github.com/dunglas/vulcain/caddy \
    --with github.com/dunglas/caddy-cbrotli \
    # You should use another storage than the default one (e.g. otter).
    # The list of the available storages can be find either on the documentation website (https://docs.souin.io/docs/storages/) or on the storages repository https://github.com/darkweak/storages
    --with github.com/caddyserver/cache-handler
    # Or use the following lines instead of the cache-handler one for the latest improvements
    #--with github.com/darkweak/souin/plugins/caddy \
    #--with github.com/darkweak/storages/otter/caddy

FROM dunglas/frankenphp:latest AS frankenphp_upstream
COPY --from=builder --link /usr/local/bin/frankenphp /usr/local/bin/frankenphp
