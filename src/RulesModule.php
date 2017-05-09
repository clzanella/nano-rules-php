<?php

namespace NanoRules;

/**
 * Description of RulesModule
 *
 * @author cleber.zanella
 */
abstract class RulesModule {
    
    const Create = 'create';
    const Update = 'update';
    const Remove = 'delete';
    
    public abstract function configure();
    
    protected function register($class, $validatorClass, array $operations){
        
    }
    
}
