# Vimeet 365

## What's Inside ?

Vimeet 365 is a client/server application using REST API to communicate with each other

The client is built using Svelte and Sapper and the server is built with Symfony

## Installation

### Prerequisite

### Backend

#### Install PHP

First you will need to install PHP 8.0 on your local machine

#### Install Docker and docker-compose

The Postgres database is running inside a docker container.

To run them docker and docker-compose are mandatory.

Please see the official documentation [here](https://docs.docker.com/engine/install/ubuntu/) and consider following the [optional post installation steps](https://docs.docker.com/engine/install/linux-postinstall/) which are recommended in order to execute docker command as non root user.

After this step you may need to restart your machine.

#### Install required dependencies for php 8.0

These dependencies are required to run the app

```
php8.0-intl php8.0-gd php8.0-xml php8.0-curl php8.0-pgsql php8.0-mbstring php8.0-apcu
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

#### Create your local environement

This project use [dotenv](https://www.npmjs.com/package/dotenv) to manage environement variables.

All you have to do is create a `.env` file containing this value

```
API_URL=http://localhost:8365/api
```
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

User name : john@example.com
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
| `localhost:8365/api` | This is the api main route              |

Note that the server's port may change if not available on server start.

**Optional** : you can setup a local proxy and define a local domain for your project to avoid this issue.

To do so please read the documentation [here](https://symfony.com/doc/current/setup/symfony_server.html#defining-the-local-domain)



 ## Team Agreement 

In all projects built at Proximum, we encourage shared code practices by the entire team.

Here are some examples of shared practices

 ### 1. Conventional Commit

We use the naming convention called ["conventional commit".](https://www.conventionalcommits.org/en/v1.0.0-beta.2/)

According to this convention, each commit that we want to integrate into the main branches (staging, main and/or master) must respect the same nomenclature, namely

```bash
<type>[optional scope]: <description>

[optional body]

[optional footer]
```

`<type>` must be one of those values : 

1. **fix:** a commit of the *type* `fix` patches a bug in your codebase (this correlates with [`PATCH`](http://semver.org/#summary) in semantic versioning).
2. **feat:** a commit of the *type* `feat` introduces a new feature to the codebase (this correlates with [`MINOR`](http://semver.org/#summary) in semantic versioning).
3. **BREAKING CHANGE:** a commit that has the text `BREAKING CHANGE:` at the beginning of its optional body or footer section introduces a breaking API change (correlating with [`MAJOR`](http://semver.org/#summary) in semantic versioning). A breaking change can be part of commits of any *type*. e.g., a `fix:`, `feat:` & `chore:` types would all be valid, in addition to any other *type*.
4. Others: commit *types* other than `fix:` and `feat:` are allowed, for example [@commitlint/config-conventional](https://github.com/conventional-changelog/commitlint/tree/master/%40commitlint/config-conventional) (based on the [the Angular convention](https://github.com/angular/angular/blob/22b96b9/CONTRIBUTING.md#-commit-message-guidelines)) recommends `chore:`, `docs:`, `style:`, `refactor:`, `perf:`, `test:`, and others. We also recommend `improvement` for commits that improve a current implementation without adding a new  feature or fixing a bug. Notice these types are not mandated by the  conventional commits specification, and have no implicit effect in  semantic versioning (unless they include a BREAKING CHANGE, which is NOT recommended). A scope may be provided to a commit’s type, to provide additional contextual information and is contained within parenthesis, e.g., `feat(parser): add ability to parse arrays`.

** Examples of conventional commits**

```
feat: allow provided config object to extend other configs

BREAKING CHANGE: `extends` key in config file is now used for extending other config files
```

Please read the full documentation about [Coventional Commit](https://www.conventionalcommits.org/en/v1.0.0-beta.2/)

**How does this impact my day to day work ?**

While developping a new feature in your feature branch, feel free to name your commit as you're pleased BUT when your PR is ready to be merged on main we STRONGLY encourage you to rename your commit following the convention decribed above.

This allows the automatic generation of the Changelog

## Tips and Tricks

### UI Kit and Design System

This project use a custom design system initiated with :heart: by Vincent Guerret. All mockups are available on Adobe XD.

The component library that implements this design system is available on [Storybook](https://storybook.js.org/).

You can access locally to storybook by running `make storybook`

Design systems facilitate design and development through reuse, consistency, and extensibility.

#### Working with icons

The design system contain a UI Kit with Icon and Illustrations components ready to use.

This UI kit is automatically generated from svg files with [SVG To Svelte](https://github.com/metonym/svg-to-svelte)

You can find a preview in Storybook inside the UIKit section

##### I need to use an icon

Each icon are a Svelte Component by itself.

You can directly import an icon like a regular svelte component

```html
<script>
  import { Iconeye } from "./ui-kit/icons/IconEye";
  import { IconBusiness } from "./ui-kit/icons/IconBusiness";
</script>

<IconBusiness />
<IconEye />
```

##### I need to change Icon color, width, height or other property

Each Icon Component suppport by default customisable properties.

Example of usage :

```html
<script>
  import { Iconeye } from "./ui-kit/icons/IconEye";
  import { IconBusiness } from "./ui-kit/icons/IconBusiness";
</script>

// Change component width and height

<IconBusiness width={30} height={45} />

// Change component fill

<IconEye fill={"blue"} />
```

##### I need to add a new icon

In order to add a new icon you will need to follow few steps :

**A. Add your svg file inside client/icons-draft folder`**

The Icon Component generation script expect to find svg files into this particular folder. Feel free to put your svg file inside.

**B. Clean your svg file**

Before converting your svg file into a svelte component you may need to clean it first.

1. Rename your svg file

   We would like to keep file name consistency. Each svg file must be in [PascalCase](https://techterms.com/definition/pascalcase) and starting by `Icon`

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

**C. Add the svg file inside `client/svgIcons` folder.**

**D . Run `node scripts/generate-components-from-svg.js` and check the `client/ui-kit-icons` folder to see your brand new genrated Icon component**

**E. Start storybook to see your icons under `Ui` section and check if it looks right.**

## Trounleshooting / FAQ
