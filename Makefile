# This Makefile requires GNU Make.
MAKEFLAGS += --silent

# Settings
C_BLU='\033[0;34m'
C_GRN='\033[0;32m'
C_RED='\033[0;31m'
C_YEL='\033[0;33m'
C_END='\033[0m'

include .env

DOCKER_ABBR=$(PROJECT_ABBR)
DOCKER_HOST=$(PROJECT_HOST)
DOCKER_PORT=$(PROJECT_PORT)
DOCKER_NAME=$(PROJECT_CONT)
DOCKER_PATH=$(PROJECT_PATH)

CURRENT_DIR=$(patsubst %/,%,$(dir $(realpath $(firstword $(MAKEFILE_LIST)))))
DIR_BASENAME=$(shell basename $(CURRENT_DIR))
ROOT_DIR=$(CURRENT_DIR)

help: ## shows this Makefile help message
	echo 'usage: make [target]'
	echo
	echo 'targets:'
	egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

# -------------------------------------------------------------------------------------------------
#  System
# -------------------------------------------------------------------------------------------------
.PHONY: hostname fix-permission host-check

hostname: ## shows local machine ip
	echo $(word 1,$(shell hostname -I))

fix-permission: ## sets project directory permission
	$(DOCKER_USER) chown -R ${USER}: $(ROOT_DIR)/

ports-check: ## shows this project ports availability on local machine
	cd docker/nginx-php && $(MAKE) port-check
	cd docker/mariadb && $(MAKE) port-check

# -------------------------------------------------------------------------------------------------
#  Wordpress https://wordpress.org/wordpress-6.4.3.zip
# -------------------------------------------------------------------------------------------------
.PHONY: wordpress-set wordpress-build wordpress-start wordpress-stop wordpress-destroy

wordpress-set: ## sets the Wordpress PHP enviroment file to build the container
	cd docker/nginx-php && $(MAKE) env-set

wordpress-build: ## builds the Wordpress PHP container from Docker image
	cd docker/nginx-php && $(MAKE) build

wordpress-start: ## starts up the Wordpress PHP container running
	cd docker/nginx-php && $(MAKE) up

wordpress-stop: ## stops the Wordpress PHP container but data won't be destroyed
	cd docker/nginx-php && $(MAKE) stop

wordpress-destroy: ## stops and removes the Wordpress PHP container from Docker network destroying its data
	cd docker/nginx-php && $(MAKE) stop clear

# -------------------------------------------------------------------------------------------------
#  Wordpress - MariaDB Database
# -------------------------------------------------------------------------------------------------
.PHONY: database-set database-build database-start database-stop database-destroy database-replace database-backup

database-set: ## sets the database enviroment file to build the container
	cd docker/mariadb && $(MAKE) env-set

database-build: ## builds the database container from Docker image
	cd docker/mariadb && $(MAKE) build

database-start: ## starts up the database container running
	cd docker/mariadb && $(MAKE) up

database-stop: ## stops the database container but data won't be destroyed
	cd docker/mariadb && $(MAKE) stop

database-destroy: ## stops and removes the database container from Docker network destroying its data
	cd docker/mariadb && $(MAKE) stop clear

database-install: ## installs an initialized database copying the determined .sql file into the container by raplacing it
	cd docker/mariadb && $(MAKE) sql-install
	echo ${C_BLU}"$(DOCKER_ABBR)"${C_END}" database has been "${C_GRN}"installed."${C_END};

database-replace: ## replaces container database copying the determined .sql file into the container by raplacing it
	cd docker/mariadb && $(MAKE) sql-replace
	echo ${C_BLU}"$(DOCKER_ABBR)"${C_END}" database has been "${C_GRN}"replaced."${C_END};

database-backup: ## creates a .sql file from container database to the determined local host directory
	cd docker/mariadb && $(MAKE) sql-backup
	echo ${C_BLU}"$(DOCKER_ABBR)"${C_END}" database "${C_GRN}"backup has been created."${C_END};

# -------------------------------------------------------------------------------------------------
#  Wordpress Project
# -------------------------------------------------------------------------------------------------
.PHONY: project-set project-build project-start project-stop project-destroy

project-set: ## sets both Wordpress and database .env files used by docker-compose.yml
	$(MAKE) wordpress-set database-set

project-build: ## builds both Wordpress and database containers from their Docker images
	$(MAKE) wordpress-set database-set database-build wordpress-build

project-start: ## starts up both Wordpress and database containers running
	$(MAKE) database-start wordpress-start

project-stop: ## stops both Wordpress and database containers but data won't be destroyed
	$(MAKE) database-stop wordpress-stop

project-destroy: ## stops and removes both Wordpress and database containers from Docker network destroying their data
	$(MAKE) database-destroy wordpress-destroy

# -------------------------------------------------------------------------------------------------
#  Wordpress Example Plugin
# -------------------------------------------------------------------------------------------------
.PHONY: plugin-zip

plugin-zip:
	cd resources/plugin/dev && zip -r ../pr-custom.zip *

# -------------------------------------------------------------------------------------------------
#  Repository Helper
# -------------------------------------------------------------------------------------------------
repo-flush: ## clears local git repository cache specially to update .gitignore
	git rm -rf --cached .
	git add .
	git commit -m "fix: cache cleared for untracked files"