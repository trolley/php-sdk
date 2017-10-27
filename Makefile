PHP=php

default: unit integration

unit:
	@$(PHP) --version
	$(PHP) ./vendor/bin/phpunit --testsuite unit

integration:
	@$(PHP) --version
	$(PHP) ./vendor/bin/phpunit --testsuite integration

# Usage:
#    make test-one TEST=./tests/integration/BatchTest.php
test-one:
	$(PHP) ./vendor/bin/phpunit $(TEST)
