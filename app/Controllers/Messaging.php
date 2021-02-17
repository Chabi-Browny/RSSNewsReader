<?php

namespace App\Controllers;


class Messaging
{
    public function trowBackMsg(string $msgContent, string $msgType = 'default')
    {
        $msgClassName = '';
        switch ($msgType){
            case 'succ':
                $msgClassName = 'success';
                break;
            case 'danger':
                $msgClassName = 'danger';
                break;
            case 'warn':
                $msgClassName = 'warning';
                break;
            default: $msgClassName = 'primary';
        }
        return '<div class="alert alert-'.$msgClassName.'">'.$msgContent.'</div>';
    }
    
}