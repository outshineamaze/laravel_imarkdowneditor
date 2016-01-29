<?php

namespace Outshine\Editor\Facade;
use Illuminate\Support\Facades\Facade;

class iMarkdownEditorFacade extends Facade{
    protected static function getFacadeAccessor(){
        return 'iMarkdownEditor';
    }
}