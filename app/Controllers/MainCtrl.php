<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

/**
 * Description of MainCtrl
 */
class MainCtrl extends BaseController{
    
    public $pagesPath = 'project/pages';
    public $sessObj = '';
    
    protected $_data = [];
    
    public function __construct() 
    {
        if( ENVIRONMENT == 'development' )
        {
            helper('develop');
        }
        
        $this->sessObj = Services::session();
        
        $this->_data['javascripts'] = [];
    }
    
    protected function checkIsLogged()
    {
        if( NULL === $this->sessObj->get('uinfo') )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
}