.PHONY: rpmbuild mock clean

rpmbuild: clean
	mbt --buildstyle=rpmbuild

mock: clean
	mbt

clean:
	rm -rf BUILD SOURCES SRPMS RPMS BUILDROOT vendor

# Intended for testing on sandbox
install: rpmbuild
	sudo yum erase -y rmp-silex-reference
	sudo yum install -y ./RPMS/*.rpm

# Sets up the app on a sandbox/host machine:
install-dev:
	npm install
	composer install
