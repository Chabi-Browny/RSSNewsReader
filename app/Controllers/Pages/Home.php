<?php

namespace App\Controllers\Pages;

use App\Controllers\MainCtrl;

class Home extends MainCtrl{
    
    public function index()
    {
        $this->_data['javascripts'] = [view($this->pagesPath.'/home/js/homeJs')];
        
        return view($this->pagesPath.'/home/home', $this->_data);
    }
}