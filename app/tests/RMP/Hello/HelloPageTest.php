<?php
/**
 * Hello test implemention
 *
 * PHP version 5.4
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Elisabeth Anderson <beth.anderson@bbc.co.uk>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/bbc-rmp/deploy-pipeline
 */

namespace RMP\Hello\Tests;

/**
 * Hello app functional test suite
 *
 * PHP version 5.4
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Elisabeth Anderson <beth.anderson@bbc.co.uk>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     https://github.com/bbc-rmp/deploy-pipeline
 */
class HelloTest extends TestCase\BaseWebTestCase
{
    /**
     * Test that the route returns an HTTP 200 code
     *
     * @return void
     */
    public function testThatThePageIsReturnedProperly()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/rmp-silex-reference/hello');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * Test that the correct content is present
     *
     * @return void
     */
    public function testThatAPersonIsCorrectlyGreeted()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/rmp-silex-reference/hello/beth');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Hello, beth!")')->count()
        );
    }
}
