#!/usr/bin/env bash

set -e
set -u
set -o pipefail

COMMAND=${1:-"help"}
TAG=dev

function build() {
    docker build -t astromech/php:$TAG .
    _run composer install
    _run composer dump-autoload -o
}

function help() {
    USAGE="Usage: $0 "$(compgen -A function | grep -v -e '^_' | tr "\\n" "|" | sed 's/|$//')
    echo $USAGE
}

function sh() {
    _run ${@:-"sh"}
}

function phpunit() {
    _run ./vendor/bin/phpunit ${@:-""}
}

function run-decoder() {
    docker run -it --rm \
        -e TERM=xterm-256color \
        -v $(pwd):/astromech-data-processor \
        -v $HOME/.composer/cache:/root/.composer/cache \
        -w /astromech-data-processor \
        -p 8000:8000 \
        astromech/php:$TAG \
        php -S 0.0.0.0:8000 -t public
}

function _run() {
    command=${@:1}
    if [ "" == "$command" ]; then
      command=sh
    fi

    docker run -it --rm \
        -v $(pwd):/astromech-data-processor \
        -v $HOME/.composer/cache:/root/.composer/cache \
        -w /astromech-data-processor \
        astromech/php:$TAG \
        $command
}

$COMMAND ${@:2}
