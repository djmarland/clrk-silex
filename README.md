Silex Application
==================

This is a silex application set up to work on AWS. It uses a virtual box machine for local development.
The local URL is: http://app.dev/


Initial Conifg from https://github.com/scotch-io/scotch-box

## Get Started

* Download and Install VirtualBox
* Download and Install Vagrant
* Install Vagrant HostsUpdater https://github.com/cogitatio/vagrant-hostsupdater
* Clone this Repository
* Run Vagrant Up (must run as administrator)
* Access Your Project at http://app.dev/

Database Name	(leave blank)
Database User	root
Database Password	root
Database Host	localhost
SSH Host	192.168.33.10
SSH User	vagrant
SSH Password	vagrant

Installed Applications
-------

The "vagrant up" will install and run:
* grunt and grunt-cli
* composer


Logging
-------

Logging uses [Monolog](https://github.com/Seldaek/monolog) and creates an $app['log'] object:

```php
$app['log'] = new Logger('log_stream');
$app['log']->pushHandler(new StreamHandler(__DIR__.'//log//'.$app['env'].'.log', Logger::DEBUG));
```

...which creates a file called _environment_.log in the app/log/ directory. The _environment_ depends
on where the app is bootstrapped and default is _production_.

then you can log to this using:
```php
$app['log']->debug("This is the thing what has happened", $optionalContextArray);
```

...with the log-levels of:

* debug
* info
* notice
* warning/warn
* error/err
* emergency/emerg
* alert
* critical/crit

...or using their synonyms ```addInfo($message, array $context = array())``` etc or the
generic ```log($level, $message, array $context = array())```
