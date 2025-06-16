## Clone a repository

    git clone git@github.com:DanHariton/rest-task.git

---

## Docker

In project folder in terminal run:

    docker-compose up -d --build

---

## Environmental variables

Enter inside PHP container

* `docker exec -it webnode_php /bin/bash`

Then copy the `.env` to `.env.local`

* `cp .env .env.local`

Edit the `.env.local` file and populate it with all necessary variables

---

#### Init project
For the first time you can use `int` command, which will do all first steps

#### Fixtures
You can load fixtures with the following command.
You have to use the `--append` option to avoid deleting all data from the database.

    bin/console doctrine:fixtures:load --append

or just use alias `fxt`

    fxt

---

## PhpStan
run

    composer phpstan

or just use alias `pps`

---

## ECS - Easy Code Standard

check all files

    composer ecs

or just use alias `pes`

check all files and fix

    composer ecs-fix

or just use alias `pesx`
