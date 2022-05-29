# Readme

## Requirements for local development

1) Docker

* Should be fine on every OS but on Windows use only WSL2

2) Make

* Should be easy to install on every unix OS including WSL

## Installation

1) Type `make env` and configure your .env file accordingly.
2) Set up your `hosts` file according to your `.env` file. (for example `bohemia.docker` -> `127.0.0.103`)
3) Type `make`.
4) Done.

* Access at <http://bohemia.docker//>

Bohemia api needs to run on local to load posts

## Commands:

Execute only in root of the project

| Command                 | Description                                                                            |
|-------------------------|----------------------------------------------------------------------------------------|
| `make`                  | Easy start up. Starts docker, installs, builds.                                        |
| `make env`              | Copies .env file. In some cases fills out some things.                                 |
| `make up`               | Starts/Restarts containers.                                                            |
| `make install`          | Installs project packages and generates JWT keys. Also runs migrations. Builds assets. |
| `make build`            | Builds assets into build folder.                                                       |
| `make watch`            | Runs asset watcher.                                                                    |

For more check **Makefile**!

## Dev notes & todo:

* Only post list and post detail works :D sorry
