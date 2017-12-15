<?php namespace JoaoJoyce\LndRestInterface;

class Testing
{

    public $test;

    public function __construct()
    {
        $this->test = "Hey";

    }

    /**
     * @return string
     */
    public function getTest()
    {
        return $this->test;
    }


}