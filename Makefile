unit-tests:
	bin/phpunit --testsuite unit

integration-tests:
	bin/phpunit --testsuite integration

system-tests:
	composer database-test
	bin/phpunit --testsuite system

e2e-tests:
	composer database-panther
	bin/phpunit --testsuite end_to_end -v

.PHONY: tests
tests:
	composer database
	bin/phpunit --testsuite unit,integration,system,end_to_end
