<?php

namespace App\CQS;

use Illuminate\Support\Facades\App;

class QueryBus {
    
    public function ask(Query $query): mixed 
    {
        $queryClassName = get_class($query);
        $queryHandlerClassName = "{$queryClassName}Handler";
        if (!class_exists($queryHandlerClassName, true)) {
            throw new \Exception("QueryHandler '{$queryHandlerClassName}' not exists");
        }

        $queryHandler = App::make($queryHandlerClassName);
        
        if (!($queryHandler instanceof QueryHandler)) {
            throw new \Exception("QueryHandler '{$queryHandlerClassName}' is not implemented with QueryHandler");
        }

        $methods = get_class_methods($queryHandler);
        $handleMethod = "handle";
        if (!in_array($handleMethod, $methods)) {
            throw new \Exception("QueryHandler '{$queryHandlerClassName}' haven't handle methode");
        }

        return $queryHandler->$handleMethod($query);
    }
}