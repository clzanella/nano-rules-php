<?php

namespace NanoRules;

/**
 * Description of ValidationSummary
 *
 * @author cleber.zanella
 */
class ValidationSummary {
    
    private $validationData;
    
    public function __construct(array $data = array())
    {
        $this->validationData = $data;
    }

    public function passed()
    {
        return count($this->validationData) == 0;
    }

    public function addField($fieldName, $message)
    {
        array_push($this->validationData, array('fieldName'=>$fieldName, 'message'=>$message));
    }

    public function addMessage($message)
    {
        $this->addField(null, $message);
    }

    public function getEntries(){
        return $this->validationData;
    }
}
