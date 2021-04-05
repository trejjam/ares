.PHONY: all test

all: ecs phpstan test
	echo "Is done"

test:
	XDEBUG_CONFIG="remote_enable=0" vendor/bin/tester -s -p php --colors 1 -C ./tests

phpstan:
	XDEBUG_CONFIG="remote_enable=0" vendor/bin/phpstan analyse -l max -c tests/config/phpstan.neon src tests/src tests/cases

cs: ecs

ecs:
	XDEBUG_CONFIG="remote_enable=0" vendor/bin/ecs check --config=bin/easy-coding-standard.php \
		src \
		bin \
		tests/src tests/cases ${ECS_PARAM}

ecsFix:
	$(MAKE) ECS_PARAM="--fix" ecs

coverage-clover:
	XDEBUG_CONFIG="remote_enable=0" vendor/bin/tester -s -p phpdbg --colors 1 -C --coverage ./coverage.xml --coverage-src ./src ./tests

coverage-html:
	XDEBUG_CONFIG="remote_enable=0" vendor/bin/tester -s -p phpdbg --colors 1 -C --coverage ./coverage.html --coverage-src ./src ./tests