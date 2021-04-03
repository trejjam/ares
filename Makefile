.PHONY: all test

all: ecs phpstan test
	echo "Is done"

test:
	XDEBUG_CONFIG="remote_enable=0" bin/run-tests

phpstan:
	XDEBUG_CONFIG="remote_enable=0" XDEBUG_CONFIG="remote_enable=0" composer run-script -- phpstan

cs: ecs

ecs:
	XDEBUG_CONFIG="remote_enable=0" vendor/bin/ecs check --config=bin/easy-coding-standard.php \
		src \
		bin \
		tests/src tests/cases ${ECS_PARAM}

ecsFix:
	$(MAKE) ECS_PARAM="--fix" ecs
