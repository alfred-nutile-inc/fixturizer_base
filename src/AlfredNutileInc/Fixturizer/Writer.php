<?php
/**
 * Created by PhpStorm.
 * User: alfrednutile
 * Date: 11/28/14
 * Time: 9:48 PM
 */

namespace AlfredNutileInc\Fixturizer;


class Writer extends BaseParser {

    protected $content_yamlized;

    public function setDestination($path)
    {
        $this->destination = $path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDestination()
    {
        return $this->destination;
    }


    public function createFixture(array $content, $name = false)
    {
        $this->content = $content;

        ($name != false) ? $this->setName($name) : false;

        $this->convert();
        $this->write();
    }

    protected function write()
    {

        if(!$this->getFilesystem()->exists($this->getDestination()))
        {
            throw new MissingFileException(sprintf("Can not write file since folder does not exist %s", $this->getDestination()));
        }

        if($this->getName() == NULL)
        {
            throw new MissingNameException("You need to setName prior to using");
        }

        try
        {
            $this->getFilesystem()->dumpFile($this->getDestination() . $this->getName(), $this->content_yamlized);
        }
        catch(\Exception $e)
        {
            $message = sprintf("Error writing file to system message %s", $e->getMessage());
            throw new \Exception($message);
        }
    }

    protected function convert()
    {
        try
        {
            $this->content_yamlized = $this->getYmlParser()->dump($this->content);
        }
        catch(\Exception $e)
        {
            $message = sprintf("Error converting array into yaml message %s", $e->getMessage());
            throw new \Exception($message);
        }
    }
} 