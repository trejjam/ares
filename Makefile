.PHONY: all test

all: test
	echo "Is done"

test: phpstan ecs sensiolab
	XDEBUG_CONFIG="remote_enable=0" bin/run-tests

phpstan:
	XDEBUG_CONFIG="remote_enable=0" XDEBUG_CONFIG="remote_enable=0" composer run-script phpstan

sensiolab:
	XDEBUG_CONFIG="remote_enable=0" vendor/bin/security-checker security:check composer.lock

ecs:
	XDEBUG_CONFIG="remote_enable=0" vendor/bin/ecs check --config=tests/config/easy-coding-standard.yml \
		src \
		tests/src tests/cases ${ECS_PARAM}

ecsFix:
	$(MAKE) ECS_PARAM="--fix" ecs
