<?php namespace AlfredNutileInc\Fixturizer;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;


class BaseParser {

    protected $destination = '/tmp';
    protected $name;
    protected $content;
    /**
     * @var \Symfony\Component\Yaml\Yaml
     */
    protected $yaml_parser;
    protected $base_fixture_storage_path;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem = null)
    {
        $this->filesystem = ($filesystem == null) ? new Filesystem() : $filesystem;
    }

    public function setYmlParser(Yaml $yaml = null)
    {
        if($yaml == null)
        {
            $yaml = new Yaml();
        }

        $this->yaml_parser = $yaml;
    }

    /**
     * @var \Symfony\Component\Yaml\Yaml
     * @return mixed
     */
    public function getYmlParser()
    {
        if($this->yaml_parser == null)
            $this->setYmlParser();
        return $this->yaml_parser;
    }

    /**
     * @return mixed
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @var Filesystem
     * @param mixed $filesystem
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setBaseFixtureStoragePath($path)
    {
        $this->base_fixture_storage_path = $path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBaseFixtureStoragePath()
    {
        return $this->base_fixture_storage_path;
    }


}