<?php


namespace NanoRules;

use DateTime;

/**
 * Description of FieldValidator
 *
 * @author cleber.zanella
 */
class FieldValidator {

    const RequiredMessage = "Campo obrigatório.";
    const EmailPatterm = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
    const IntegerNumberPattern = "/^[0-9]+$/";
    const WebSitePattern = "/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/";
    
    const DateFormat = 'Y-m-d';
    
    private $summary;
    private $fieldName;
    private $fieldValue;
    
    public function __construct(ValidationSummary $summary)
    {
        $this->summary = $summary;
    }
    
    public function setField($fieldName, $fieldValue){
        $this->fieldName = $fieldName;
        $this->fieldValue = $fieldValue;
    }
    
    public function notNullOrEmpty($isOptionalField = false){
        
        $nullOrEmpty = !isset($this->fieldValue) || trim($this->fieldValue)==='';
        
        if(! $isOptionalField && $nullOrEmpty){
            $this->summary->addField($this->fieldName, FieldValidator::RequiredMessage);
        }
        
        return ! $nullOrEmpty;
    }

    public function notNull($isOptionalField = false){
        
        $null = !isset($this->fieldValue);
        
        if(! $isOptionalField && $null){
            $this->summary->addField($this->fieldName, FieldValidator::RequiredMessage);
        }
        
        return ! $null;
    }

    public function length($min, $max){
        
        $fieldValueLength = strlen($this->fieldValue);
        $matchesLength = $fieldValueLength >= $min && $fieldValueLength <= $max;
        
        if(! $matchesLength){
            $this->summary->addField($this->fieldName, sprintf("O valor precisa ter entre %1d e %2d caracteres, e está com %3d.", $min, $max, $fieldValueLength));
        }
        
        return ! $matchesLength;
    }

    public function maxLength($max){
        $fieldValueLength = strlen($this->fieldValue);
        $matchesLength = $fieldValueLength <= $max;
        
        if(! $matchesLength){
            $this->summary->addField($this->fieldName, sprintf("O valor precisa ter no máximo %1d caracteres, e está com %2d.", $max, $fieldValueLength));
        }
        
        return ! $matchesLength;
    }

    public function notEmptyArray(){
        $arraySize = count($this->fieldValue);
        $empty = $arraySize <= 0;

        if($empty){
            $this->summary->addField($this->fieldName, FieldValidator::RequiredMessage);
        }

        return ! $empty;
    }
    
    public function minSize($min){
        $arraySize = count($this->fieldValue);
        $matchesSize = $arraySize >= $min;

        if(! $matchesSize){
            $this->summary->addField($this->fieldName, sprintf("É necessário selecionar no mínimo %1d item(s), há apenas %2d selecionado(s).", $min, $arraySize));
        }

        return ! $matchesSize;
    }

    protected function baseRegex($pattern, $skip = false){
        $matches = preg_match($pattern, $this->fieldValue) == 1;
        
        if(! $skip && ! $matches){
            $this->summary->addField($this->fieldName, sprintf('O valor "%1s" não atende o regex "%2s".', $this->fieldValue, $pattern));
        }
        
        return ! $matches;
    }

    public function regex($pattern){
        return $this->baseRegex($pattern);
    }
    
    public function email(){
        $notMatches = $this->baseRegex(FieldValidator::EmailPatterm, true);
        
        if($notMatches){
            $this->summary->addField($this->fieldName, sprintf('O valor "%1s" é um email inválido.', $this->fieldValue));
        }
        
        return $notMatches;
    }
    
    public function intNumber(){
        $notMatches = $this->baseRegex(FieldValidator::IntegerNumberPattern, true);

        if($notMatches){
            $this->summary->addField($this->fieldName, sprintf('O valor "%1s" não representa um número inteiro.', $this->fieldValue));
        }
        
        return $notMatches;
    }
    
    public function website(){
        $notMatches = $this->baseRegex(FieldValidator::WebSitePattern, true);

        if($notMatches){
            $this->summary->addField($this->fieldName, sprintf('O valor "%1s" não representa um endereço de website (URL).', $this->fieldValue));
        }
        
        return $notMatches;
    }

    public function date(){
        $isADate = DateTime::createFromFormat(FieldValidator::DateFormat, $this->fieldValue)  !== false;

        if(! $isADate){
            $this->summary->addField($this->fieldName, sprintf('O valor "%1s" não é uma data válida.', $this->fieldValue));
        }
        
        return ! $isADate;
    }
    
}