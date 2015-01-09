[![Build Status](https://travis-ci.org/alfred-nutile-inc/fixturizer_base.svg?branch=master)](https://travis-ci.org/alfred-nutile-inc/fixturizer_base)

# Fixturizer 

Quick way to write and read fixture data. 

Takes php arrays and quickly puts them on the filesystem as yaml files and vice versa.

See tests folder for Test Examples

## Non Laravel Usage

You can see in the tests/FixturizerTest.php file some examples of usage. 
The main goal being that Writer or Reader allow you to easily pass a filename
and path to get or put the file / fixture data in yml format.


## If you are using Laravel

Load up the Provider and Facades

config/app.php load under Providers

~~~

    'AlfredNutileInc\Fixturizer\FixturizerServiceProvider'
~~~

Load under Facades

~~~

    'FixturizerReader' => 'AlfredNutileInc\Fixturizer\FixturizerReader',
    'FixturizerWriter' => 'AlfredNutileInc\Fixturizer\FixturizerWriter',
~~~

Then you can use it as seen below in a test file

~~~

    <?php 
    
    use AlfredNutileInc\Fixturizer\FixturizerReader;
    use AlfredNutileInc\Fixturizer\FixturizerWriter;
    
    class FixtureTest extends \TestCase {

        /**
         * @test
         */
        public function should_write_fixture()
        {
            $fixture = ['foo' => 'bar'];
            FixturizerWriter::createFixture($fixture, 'foo.yml');
            $this->assertFileExists(FixturizerWriter::getDestination() . 'foo.yml');
        }
    
        /**
         * @test
         */
        public function should_read_fixture()
        {
            $name = 'foo.yml';
            $path = base_path() . '/tests/fixtures/';
            $results = FixturizerReader::getFixture($name, $path);
            $this->assertNotNull($results);
        }
    } 
~~~

