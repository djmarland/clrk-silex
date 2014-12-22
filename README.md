Silex Reference App
==================

Initial Conifg from https://github.com/scotch-io/scotch-box

## Get Started

* Download and Install Vagrant
* Download and Install VirtualBox
* Clone this Repository
* Run Vagrant Up
* Access Your Project at  http://192.168.33.11/

Database Name	(leave blank)
Database User	root
Database Password	root
Database Host	localhost
SSH Host	192.168.33.10
SSH User	vagrant
SSH Password	vagrant

This project is intended to pull together some ideas into a reference app. It's a
work in progress and is intended for review only.

Install Grunt
-------

The reference app uses Grunt for its front-end tests and Javascript require
minification. To get setup using Grunt you first need Node.JS (OSX: you could
probably do this with homebrew, but its better to make sure its a recent version)
Node.JS comes with NPM, so next install grunt-cli by running:
```
npm install -g grunt-cli
```

*Note:*
*If you get errors from NPM not being able to write to your folder, check the current*
*user is in the correct group to write to /usr/local then try again. This is because*
*NPM stores its files in the /usr/local folder and will need permission to use it.*
*The -g will install grunt globally.*

Go to the radio directory and run:
```
npm install
```

Grunt commands:
* `grunt` will recompile modules into dist-modules folder. (`grunt ci` will compress the modules)
* `grunt test` will run Jasmine through all the specs in the spec folder in script-test.
* `grunt watch` will recompile modules into dist-modules folder on change

Install dependencies
-------

In the sandbox install: `composer install`. (using PHP 5.4 `scl enable php54 'composer install'`)

Running
-------

To start the server instance on port 8000, run the following in your cosmos sandbox:

```sh
script\server
```

...which will use the _development_ environment by default. If you specify another
environment by 'exporting' it, then it will use that. So:

```sh
APP_ENV=production script\server
```

...will start the app in production mode, etc.

To start the file watcher for static asset compliation run:

```sh
grunt watch
```


Starting the server using Apache actually on production we'd use something like:

```xml
<VirtualHost *:80>
    SetEnv APP_ENV production
</VirtualHost>
```

..which would run the app in production mode. Use the ```$app['env']``` object to
get the current environment, one of [development|test|production].

Endpoints
---------

| Action  | URL                                      |
| ------- | ---------------------------------------- |
| Home    | /                                        |
| Index   | /hello                                   |
| Show    | /hello/{yourname}                        |
| Destroy | /goodbye/{yourname} (feature set to off) |

Config
------

The app uses [werx/config](https://github.com/werx/config) (as it has a composer
package). It uses the ArrayProvider rather than the JsonProvider for speed.

Config lives under the following structure:

```
config/
    config.php
    another_config.php
    /development/
        config.php
    /test/
        config.php
    /production/
        config.php
```

The top-level config contains the defaults, which are used unless overridden by
a value in an environment-specific config. The values are declared in an array:

```php
<?php
return [
    'foo' => 'Default Foo',
    'bar' => 'Default Bar'
];
```

Routing
---------------

Rather than using standard Silex routing, such as:

```php
$app->put('/blog/{id}', function ($id) {
    // ...
});
```

...I wanted clean routing so I 'require' config/Routes.php which defines
my route mappings. I also include lib/helpers/RoutesHelper.php which implements a string
mapping helper function that maps clean routes such as /widget/{id} to BBC\App\WidgetController::viewAction
controller functions.

So I can define a route using:

```php
$app->match('/widget/{widget_id}', route('widget/show'))->bind('widget');
```

So this maps /widget/1 to App\WidgetController::viewAction, and in the controller
function I can use:

```php
$widgetId = $request->attributes->get('widget_id');
```

...to get the ID for the specific widget. Using ->bind means this route is available in
the app's RouteCollection and can be used elsewhere—a bit like Rails routes.

I'm using 'configuration through code' rather than declaring my routes using a text
format like YAML or JSON as it's expensive to parse text and unless the routes are
changing out of sync with an app deployment (which would be odd) then they can be
code.

'Proper' Controllers
---------------

I also wanted 'proper' controllers to keep the rest of my code clean, so in my app/controllers directory
I have Hello/HelloController which looks like:

```php
namespace Hello;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class HelloController {

    public function indexAction(Request $request, Application $app) {
        return $app['twig']->render('hello.html.twig', array('name' => 'World!'));
    }

    public function showAction(Request $request, Application $app) {
        $name = $request->attributes->get('name');

        // Do look-up code here

        return $app['twig']->render('hello.html.twig', array('name' => $name));
    }

    public function destroyAction(Request $request, Application $app) {
        $name = $request->attributes->get('name');

        // Do look-up/delete code here

        return $app['twig']->render('destroy.html.twig', array('name' => $name));
    }
}
```

NB: The function name doesn't have to be index _Action_ but just index. I used
_actionAction_ so there is a clear separation of the mapping and the function definition.

All of the controllers are PSR-0 auto-loaded by adding into my composer.json:

```json
"autoload": {
    "psr-0": {
        "Hello\\": "app/controllers/"
    }
}
```

...so new controllers can be used as soon as they're dropped into the app/controllers/BBC/Hello
directory rather than having to be 'included'.

Twig Views
---------------

All of the Twig template views inherit the 'base' template; base.html.twig. This
provides the standard layout for the application.

```html
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{% block title %}Test Application{% endblock %}</title>
    </head>
    <body>
        <div id="content">
            {% block body %}{% endblock %}
        </div>
    </body>
</html>
```

Each individual view provides specific content for the blocks; 'title' and 'body' in this
example.

A view for a specific action is in the views/controllername director and looks like:

```php
{% extends 'base.html.twig' %}

{% block title %}Saying hello to {{name}}!{% endblock %}

{% block body %}

    <p>Hello, {{name}}!</p>

{% endblock %}

```

...which then renders the html:

```html
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Saying hello to beth!</title>
    </head>
    <body>
        <div id="content">

    <p>Hello, beth!</p>


        </div>
    </body>
</html>
```

This keeps the individual Twig templates clean and only containing content specific
to that view, without any application-specific cruft. If you don't specify any content
for a block, for example the 'title', then the default of 'Test Application' is used
from the base template.

Feature Switches
---------------

Using [Rollout](https://github.com/opensoft/rollout) you can turn features on or off
dynamically. Define features in code using:

```php
if ($app['feature']->isActive('featurename')) {
    // The PHP thing
}
```

...in PHP-style. Or you can use Twig-style:

```php
{% if is_active('featurename') %}
    <!-- The HTML feature -->
{% endif %}
```

...in Twig templates. Then the feature can be flipped on using:

```php
$app['feature']->activate('featurename');
$app['feature']->activateGroup('internal', 'featurename');
$app['feature']->activatePercentage('featurename', 20);
// etc
```
...and off using:

```php
$app['feature']->deactivate('featurename');
$app['feature']->deactivateGroup('internal');
```

Logging
-------

Logging uses [Monolog](https://github.com/Seldaek/monolog) and creates an $app['log'] object:

```php
$app['log'] = new Logger('bbc_deploy_pipeline');
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


Circuit Breakers
---------------

To provide resilience against a cascade of failures, the app uses a
[CircuitBreaker](https://github.com/betandr/circuitbreaker) implementation which
monitors successful and non-successful transactions then provides feedback if the
failures reach a certain threshold.

The circuit breaker is used by checking :

```php
if ($app['breaker']->isOpen()) {
    try {
        // YOUR EXPENSIVE CALL HERE
        $app['breaker']->success();

    } catch (Exception $e) {
        // log a failure
        $app['breaker']->failure();
    }
} else {
    // FALLBACK TO SOMETHING ELSE HERE
}
```

Then if the system reaches a threshold of failures (i.e. a back-end is not
responding) then the system can 'trip' (open) the circuit so the request is no
longer performed. This can prevent systems from timing out and causing more issues
by continually attempting requests on services which are experiencing issues.


Testing
---------------

Functional testing is done using Silex\WebTestCase which provides a mock container to
run the app in. The tests are run using `phpunit` from the project directory.

```php
namespace BBC\Tests\Hello;

use Silex\WebTestCase;

class HelloTest extends WebTestCase {

    public function createApplication() {
        $app_env = 'test';

        $app = require __DIR__.'/../../../../app.php';
        $app['exception_handler']->disable();

        return $app;
    }

    public function testThatThePageIsReturnedProperly() {
        $client = $this->createClient();

        $crawler = $client->request('GET','/hello');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testThatAPersonIsCorrectlyGreeted() {
        $client = $this->createClient();

        $crawler = $client->request('GET','/hello/beth');

        $this->assertGreaterThan(0,
            $crawler->filter('html:contains("Hello, beth!")')->count()
        );
    }
}
```

The _createApplication_ function runs before every test function but I found that after
one invocation the routes were being included twice (if you use require_once for the routes
then this breaks too) so I wrapped the route(...) function definition in the RoutesHelper in a
!function_exists to avoid the error.

NB: this is not 'unit testing' but functional testing. Plain Ol' Unit testing is done using
phpunit in the usual way. :)

ORB
----

ORB is included using [Jay's ORB Client(tm)](https://github.com/bbc-rmp/bbc-orb-client)
as a composer dependency. The ORB segments are included using Twig:

```php
{{ orb('head')|raw }}
```

...in the base.html.twig template.


TODO
-----

* Implement passing environment into bootstrapped application

* Implement environmental config (but using PHP instead of JSON?) such as [ConfigServiceProvider](https://github.com/igorw/ConfigServiceProvider)

* The controllers should be lightweight so implement logic in services...something like:

```php
$app['programmes']->getNextOn("bbc_radio_one");
```

...which can be called from controllers and not pollute them with too much logic.

![much logic](http://i.imgur.com/ADHofbG.jpg "Many debug")
