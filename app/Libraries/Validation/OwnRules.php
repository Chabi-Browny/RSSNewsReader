<?php

namespace App\Libraries\Validation;

use App\Models\UserFeedMdl;
use Config\Services;

class OwnRules {
    
    public $sessObj = '';
    private $_uFeedMdlObj = '';

    public function __construct() {
        $this->_uFeedMdlObj = new UserFeedMdl();
    }
    
    public function checkUserlinkUnique(string $xmlLink): bool
    {
        $this->sessObj = Services::session();
        $userLinks = $this->_uFeedMdlObj->getUserFeeds( $this->sessObj->get('uinfo'), TRUE);

        if( !in_array($xmlLink, $userLinks))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}