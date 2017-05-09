<?php

namespace NanoRules;

use NanoRules\Utilities\TypeCheck\DynamicProxy;
use NanoRules\Utilities\TypeCheck\PropertyHandler;

/**
 * Description of ClassValidation
 *
 * @author cleber.zanella
 */
abstract class ClassValidator {
    
    /**
     * @var ValidationSummary 
     */
    private $summary;
    
    private $lastParentClass;
    private $lastPropertyHandler;
    private $fields = array();

    private $validationCandidate;

    public function __construct() {
        $this->summary = new ValidationSummary();
    }
    

    protected function fromClass($className){
        
        $this->lastParentClass = $className;
        
        $this->lastPropertyHandler = new class implements PropertyHandler {
            
            public $lastPropertyName;

            public function handleProperty($operation, $propertyName, $propertyValue) {

                $this->lastPropertyName = $propertyName;
                
            }
            
        };
        
        return DynamicProxy::proxy($className, $this->lastPropertyHandler);
    }

    public abstract function validation();
    
    protected function field($fieldAccess) : FieldValidator {
        
        $lastPropertyName = $this->lastPropertyHandler->lastPropertyName;
        
        array_push($this->fields, $lastPropertyName);
        
        $fieldValue = null;
        
        if(isset($this->validationCandidate)){
            $fieldValue = $this->validationCandidate->{$lastPropertyName};
        }
        
        $fieldValidator = new FieldValidator($this->summary);
        $fieldValidator->setField($lastPropertyName, $fieldValue);
        
        return $fieldValidator;    
        
    }

    public function validate($candidate) : ValidationSummary{
        
        $this->validationCandidate = $candidate;
        $this->validation();
        
        return $this->summary;
    }
    
}
