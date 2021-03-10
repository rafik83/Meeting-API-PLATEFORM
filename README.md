

# Vimeet 365

## What's Inside ?

Vimeet 365 is a client/server application using REST API to communicate with each other

The client is built using Svelte and Sapper and the server is built with Symfony

## Installation

### Prerequisite

### Backend

#### Install PHP

First you will need to install PHP 7.4 on your local machine

#### Install Docker and docker-compose

The Postgres database is running inside a docker container.

To run them docker and docker-compose are mandatory.

Please see the official documentation [here](https://docs.docker.com/engine/install/ubuntu/) and consider following the [optional post installation steps](https://docs.docker.com/engine/install/linux-postinstall/) which are recommended in order to execute docker command as non root user.

After this step you may need to restart your machine.

#### Install required dependencies for php 7.4

These dependencies are required to run the app

```
php7.4-intl php7.4-gd php7.4-xml php7.4-curl php7.4-pgsql php7.4-mbstring php7.4-apcu
```

#### Create your local env

During the dev process, you may want to use a different environment configuration than the production one.

You can override the production configuriation by creating a `.env.local` file and overriding the existing variables.


Exemple :

You can override the current `CORS_ALLOW_ORIGIN` variable by replacing it with `CORS_ALLOW_ORIGIN='*'`


### Frontend

First install [NodeJs](https://nodejs.org/en/) on your local machine.

We encourage you to use [NVM](https://github.com/nvm-sh/nvm) to manage several node versions on your locale machine.

Once you've install nvm, you can install node by running

```
nvm install --lts
```

### Setup

Once you've successfully followed the prerequisites steps, you're ready to setup your local environement
At repository root level, there is a `Makefile` containing few convenient scripts that might help you.

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
make watch-css
```

### Login and default user

Once you started the application you can log in with a previously stored user.

Here are his credentials 

User name : john@doe.com
Pasword : password

### Useful Command Summary

| Command          | What it does ?                                                |
| ---------------- | ------------------------------------------------------------- |
| `make install`   | Install the dependencies for both api and client              |
| `make start`     | Start the symfony and sapper server                           |
| `make test`      | Run unit test fort both api and client                        |
| `make lint`      | Lint the entire project against linters (php stan and eslint) |
| `make help`      | List all available commands                                   |
| `make watch-css` | Watch css changes                                             |
| `make storybook` | start a storybook server development                          |

### Routes to know

| Port number          | What's running on ?                     |
| -------------------- | --------------------------------------- |
| `localhost:3000`     | The port where is running sapper server |
| `localhost:8000/api` | This is the api main route              |

Note that the server's port may change if not available on server start.

**Optional** : you can setup a local proxy and define a local domain for your project to avoid this issue.

To do so please read the documentation [here](https://symfony.com/doc/current/setup/symfony_server.html#defining-the-local-domain)


## UI and Design System 

This project use a custom design system initiated with :heart: by Vincent Guerret. All mockups are available on Adobe XD.

The component library that implements this design system is available on [Storybook](https://storybook.js.org/).

You can access locally to storybook by running `make storybook`

Design systems facilitate design and development through reuse, consistency, and extensibility.

## Working with icons

The component library contains a set of icon components used accross the application. Those icon components are automatically generated from svg files with [SVG To Svelte](https://github.com/metonym/svg-to-svelte)

You can find a preview in Storybook

### I need to use an icon

Each icon are a Svelte Component by itself.

You can directly import an icon like a regular svelte component

```html
<script>
  import Iconeye from "./components/icons/IconEye";
  import IconBusiness from "./components/icons/IconBusiness";
</script>

<IconBusiness />
<IconEye />
```

### I need to change Icon color, width, height or other property

Each Icon Component suppport by default customisable properties. 

Example of usage : 

```html
<script>
  import Iconeye from "./components/icons/IconEye";
  import IconBusiness from "./components/icons/IconBusiness";
</script>

// Change component width and height

<IconBusiness width={30} height={45} />

// Change component fill

<IconEye fill={"blue"} />
```

### I need to add a new icon

In order to add a new icon you will need to follow few steps :

**A. Clean the svg icon file**

Before converting the svg icon file to a svelte component you may need to clean it first.

1. Rename your svg file

   We would like to keep file name consistency. Each svg file must be in [Pascal case](https://techterms.com/definition/pascalcase) and starting by `Icon`

   Exemple : IconEye, IconBusiness

   
2. Remove global styles

   Sometimes your svg file can use css classes. Those css classes are considered as global style by the navigator and can produce nasty side effetcs

   If your svg file contains a `<style>` tag with classes like this :

   ```svg
   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
       <defs>
           <style>
           .a{fill:#fff;opacity:0;}
           </style>
       </defs>
       <path class="a"> </path>
   </svg>
   ```

   You have to convert those styles into tag props

   ```svg
   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
   <path fill="#fill" opacity="0"> </path>
   </svg>
   
   ```

3. Remove hard coded `width` and `height`

   We want to be able to set the icon width and height dynamically so if your SVG has `width` and `height` hard coded properties, please remove them. 

4. (optional) Remove hard coded fill and stroke

   We also want to be able to set the icon color dynamicaly. Sometimes, it is required to remove hard coded `fill` and `stroke` property.

   **BUT BE CAREFULL** This will work only with monochromatic icons. If your svg file has many different fill and stroke property with different values it is advised to not remove those  properties.

   Please see `IconFlagEN` or `IconFlagFR` for an example of mutli chromatic icons

   

**B. Add the svg file inside `client/svgIcons` folder.**

**C . Run `make generate icons` and check the `component/icons` folder to see your brand new genrated Icon component**

**D. Start storybook to see your icons under `Icons` section and check if it looks right.**



#### Trounleshooting / FAQ
