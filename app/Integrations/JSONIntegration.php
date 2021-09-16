<?php

namespace App\Integrations;

class JSONIntegration
{
    public $toInsert;
    public $toUpdate;
    private $url;
    private $attribs;
    public $exceptions = array();

    public function __construct()
    {
        $this->attribs = array_keys(get_class_vars(__CLASS__));
    }

    public function get($name)
    {
        if (in_array($name, $this->attribs) && $name != 'attribs') {
            return $this->$name;
        } else {
            throw new \Exception('There is no such attribute yet.');
        }
    }

    public function set($name, $value)
    {
        if (in_array($name, $this->attribs) && $name != 'attribs') {
            $this->$name = $value;
        } else {
            $this->exceptions[] = ['There is no such attribute yet.' => $value];
        }
    }

//json albo array
    function fetchFromAPI($json = 'no')
    {
        if ($json == 'no') {
            $json = json_decode(file_get_contents($this->url), true);
        } else {

            $json = json_decode(file_get_contents($this->url));
        }
        if (empty($json)) {
            $this->exceptions[] = 'Błąd z API zewnętrznym';
        }
        return $json;
    }
}
