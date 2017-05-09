<?php

namespace NanoRules\Tests\DtoValidation;

use NanoRules\ClassValidator;
use NanoRules\Tests\DTO\Empresa;

/**
 * Description of EmpresaValidator
 *
 * @author cleber.zanella
 */
class EmpresaValidator extends ClassValidator {

    protected function e() : Empresa {
        return $this->fromClass(Empresa::class);
    }

    public function validation() {
        
        $validator = $this->field($this->e()->nome);
        if($validator->notNullOrEmpty()){
            $validator->length(3, 80);
        }

        $validator = $this->field($this->e()->cep);
        if($validator->notNullOrEmpty(true)){ // campo é opcional
            $validator->length(8, 8);
            $validator->intNumber();
        }

        $validator = $this->field($this->e()->endereco);
        if($validator->notNullOrEmpty()){
            $validator->length(3, 120);
        }

        $validator = $this->field($this->e()->telefone1);
        if($validator->notNullOrEmpty()){
            $validator->length(12, 13);
            $validator->intNumber();
        }

        $validator = $this->field($this->e()->telefone2);
        if($validator->notNullOrEmpty(true)){
            $validator->length(12, 13);
            $validator->intNumber();
        }

        $validator = $this->field($this->e()->email1);
        if($validator->notNullOrEmpty()){
            $validator->length(3, 40);
            $validator->email();
        }

        $validator = $this->field($this->e()->email2);
        if($validator->notNullOrEmpty(true)){
            $validator->length(3, 40);
            $validator->email();
        }

        $validator = $this->field($this->e()->website);
        if($validator->notNullOrEmpty(true)){
            $validator->length(5, 80);
            $validator->website();
        }

        $validator = $this->field($this->e()->categorias);
        if($validator->notNull()){
            if($validator->notEmptyArray()){
                $validator->minSize(1);
            }
        }

        $validator = $this->field($this->e()->observacoes);
        if($validator->notNullOrEmpty(true)){
            $validator->length(10, 250);
        }
        
        $validator = $this->field($this->e()->logomarca);
        if($validator->notNullOrEmpty(true)){
            $validator->intNumber();
        }        
        
    }

}
