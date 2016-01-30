<?php

namespace Outshine\Editor;

use Illuminate\Support\Facades\Request;

class iMarkdownEditor{

    static $_errors=array();

    protected static function addError($message){
        if(!empty($message)){
            self::$_errors[] = $message;
        }
    }

    protected static function getLastError(){
        return empty(self::$_errors) ? '' : array_pop(self::$_errors);
    }

    /**
     * EndaEditor Upload ImgFile
     * @param string $path
     * @return array
     */
    public static function uploadImgFile($path){
        try{
            // File Upload
            if (Request::hasFile('image')){
                $pic = Request::file('image');
                if($pic->isValid()){
                    $newName = md5(rand(1,1000).$pic->getClientOriginalName()).".".$pic->getClientOriginalExtension();
                    $pic->move($path,$newName);
                    $url = asset($path.'/'.$newName);
                }else{
                    self::addError('The file is invalid');
                }
            }else{
                self::addError('Not File');
            }
        }catch (\Exception $e){
            self::addError($e->getMessage());
        }

        $data = array(
            'status'=>empty($message)?0:1,
            'message'=>self::getLastError(),
            'url'=>!empty($url)?$url:''
        );

        return $data;
    }


    /**
     * 转换 mark 文本
     * @param $markdownText
     * @return string
     */
    public static function MarkDecode($markdownText){
       /* $parsedown = new \Outshine\Editor\Parsedown();
        return $parsedown->text($markdownText);*/

        $parser = new \cebe\markdown\Markdown();
        $parser->parse($markdownText);
    }

}