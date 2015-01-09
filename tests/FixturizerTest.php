<?php namespace AlfredNutileInc\Tests;

use AlfredNutileInc\Fixturizer\Reader;
use AlfredNutileInc\Fixturizer\Writer;
use PHPUnit_Framework_TestCase;

class FixturizerTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function should_save_as_yaml()
    {
        $this->cleanUpFile();
        $fixturizer = new Writer();
        $path = __DIR__ . '/tmp/';
        $fixturizer->setDestination($path)->setName('foo.yml');

        $this->assertFileNotExists($fixturizer->getDestination() . 'foo.yml');

        $fixture = $this->getFixtureSampleArray();
        $fixturizer->createFixture($fixture);
        $this->assertFileExists($fixturizer->getDestination() . 'foo.yml');
    }

    /**
     * @test
     */
    public function shortcut_to_set_name_and_no_path_for_write()
    {
        $fixturizer = new Writer();
        $path = __DIR__ . '/tmp/';
        $fixturizer->setDestination($path)->setName('foo.yml');
        $this->assertFileNotExists($fixturizer->getDestination() . 'foo.yml');
        $fixturizer->createFixture($this->getFixtureSampleArray(), 'foo.yml');
        $this->assertFileExists($fixturizer->getDestination() . 'foo.yml');
    }

    /**
     * @test
     */
    public function should_read_file_and_make_into_php_array()
    {
        $this->setUpFixtureYml();
        $fixturizer = new Reader();
        $path = __DIR__ . "/tmp/";
        $fixturizer->setBaseFixtureStoragePath($path);
        $fixturizer->setName('foo.yml');
        $fixturizer->convertYmlToArray();
        $result = $fixturizer->getContentArray();
        $this->assertArrayHasKey('foo', $result);
    }

    /**
     * @test
     */
    public function shortcut_to_set_name_and_no_path_for_read()
    {
        $this->setUpFixtureYml();
        $fixturizer = new Reader();
        $path = __DIR__ . "/tmp/";
        $fixturizer->getFixture('foo.yml', $path);
        $result = $fixturizer->getContentArray();
        $this->assertArrayHasKey('foo', $result);
    }

    /**
     * @expectedException \AlfredNutileInc\Fixturizer\MissingFileException
     * @test
     */
    public function should_fail_if_folder_does_not_exist()
    {
        $this->setUpFixtureYml();
        $fixturizer = new Reader();
        $path = __DIR__ . "/foobarland/";
        $name = 'foo.yml';
        $fixturizer->setBaseFixtureStoragePath($path);
        $fixturizer->setName($name);
        $fixturizer->convertYmlToArray();
        $result = $fixturizer->getContentArray();
        $this->assertArrayHasKey('foo', $result);
    }

    /**
     * @expectedException \AlfredNutileInc\Fixturizer\MissingFileException
     * @test
     */
    public function should_fail_can_not_write_to_folder()
    {
        $this->setUpFixtureYml();
        $fixturizer = new Writer();
        $path = __DIR__ . "/foobarland/foo.yml";
        $fixturizer->setDestination($path)->setName('foo.yml');
        $fixture = $this->getFixtureSampleArray();
        $fixturizer->createFixture($fixture);
        $this->assertFileExists($fixturizer->getDestination() . 'foo.yml');
    }

    protected function getFixtureSampleArray()
    {
        return [
            'foo' => 'foo2',
            'bar' => ['foo2' => 'bar2']
        ];
    }

    protected function setUpFixtureYml()
    {
        $data = <<<HEREDOC
foo: foo2
bar:
    foo2: bar2

HEREDOC;
        file_put_contents(__DIR__ . "/tmp/foo.yml", $data);
    }

    public function tearDown()
    {
        $this->cleanUpFile();
    }

    protected function cleanUpFile()
    {
        $path = __DIR__ . '/tmp/';

        if(file_exists($path . "foo.yml"))
        {
            unlink($path . "foo.yml");
        }
    }
} 