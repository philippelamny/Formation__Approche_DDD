<?php

namespace App\CQS;

use Illuminate\Support\Facades\App;

class CommandBus {
    
    public function execute(Command $command): mixed 
    {
        $commandClassName = get_class($command);
        $commandHandlerClassName = "{$commandClassName}Handler";
        if (!class_exists($commandHandlerClassName, true)) {
            throw new \Exception("CommandHandler '{commandHandlerClassName}' not exists");
        }

        $commandHandler = App::make($commandHandlerClassName);
        
        if (!($commandHandler instanceof CommandHandler)) {
            throw new \Exception("CommandHandler '{commandHandlerClassName}' is not implemented with CommandHandler");
        }

        $methods = get_class_methods($commandHandler);
        $handleMethod = "handle";
        if (!in_array($handleMethod, $methods)) {
            throw new \Exception("CommandHandler '{commandHandlerClassName}' haven't handle methode");
        }

        return $commandHandler->$handleMethod($command);
    }
}