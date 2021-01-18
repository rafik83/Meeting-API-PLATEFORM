# Vimeet 365

## What's Inside ?

Vimeet 365 is a client/server application using REST API to communicate with each other

The client is build using Svelte and Sapper and the server is build with Symfony

## Installation

### Prerequisite

### Backend

#### Install PHP

First you will need to install PHP 7.x on your local machine


#### Install Docker and docker-compose

The PostGres ad Redis dependencies are running inside a docker container. 

To run them docker and dokcer-compose are mandatory.

Please see the official documentation [here](https://docs.docker.com/engine/install/ubuntu/) and consider following the [optional post installation steps](https://docs.docker.com/engine/install/linux-postinstall/) which are recommended in order to execute docker command as non root user.

After this step you may need to restart your machine.


#### Install required dependencies for php 7.4

These dependencies are required to run the app

```
php7.4-intl php7.4-gd php7.4-xml php7.4-curl php7.4-mysql php7.4-mbstring php7.4-apcu
```

### Frontend

First install [NodeJs](https://nodejs.org/en/) on your local machine. 

We encourage you to use [NVM](https://github.com/nvm-sh/nvm) to manage several node versions on your locale machine.

Once you've install nvm, you can install node by running

```
nvm install --lts
```

### Setup

Once you've successfully followed the prerequisites steps, you're ready to setup your local environement
At repository root level, there is a `Makefile` containing few convinent scripts that might help you.

#### Install the dependencies

Run this make command

```
make install
```

#### Start the docker sever

```
docker-compose up -d
```

#### Start the application

```
make start
```


### Useful Command Summary

| Command        | What it does ?                                                |
| -------------- | ------------------------------------------------------------- |
| `make install` | Install the dependencies for both api and client              |
| `make start`   | Start the symfony and sapper server                           |
| `make test`    | Run unit test fort both api and client                        |
| `make lint`    | Lint the entire project against linters (php stan and eslint) |

### Routes to know

| Port number          | What's running on ?                                           |
| -------------------- | ------------------------------------------------------------- |
| `localhost:3000`     | The port where is running sapper server                       |
| `localhost:8000/api` | This is the api main route                                    |

#### Trounleshooting / FAQ
