<?php

namespace NanoRules\Tests\DtoValidation;

use NanoRules\RulesModule;
use NanoRules\Tests\DTO\Empresa;
use NanoRules\Tests\DtoValidation\EmpresaValidator;

/**
 * Description of DefaultModule
 *
 * @author cleber.zanella
 */
class DefaultModule extends RulesModule {
    
    public function configure() {
    
        $this->register(Empresa::class, EmpresaValidator::class, array(RulesModule::Create, RulesModule::Update));
        
    }

}
