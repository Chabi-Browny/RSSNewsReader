<?php

namespace App\Controllers\Auth;

use App\Controllers\MainCtrl;
use App\Models\AuthMdl;
use Config\Services;
/**
 * Description of Registration
 *
 */
class Registration extends MainCtrl{
    
    private $_authMdlObj = '';
    
    public function __construct() {
        $this->_authMdlObj = new AuthMdl();
    }
    
    public function reg()
    {
        $request = Services::request();
        
        if($request->isAJAX() === TRUE)
        {
            $valid = Services::validation();
            $posts = $request->getPost();
            
            $valid->setRules([
                'regname'=>[
                    'label'=>'Felhasználó név',
                    'rules'=>'required|alpha_numeric|is_unique[users.u_name]',
                    'errors'=>
                    [
                        'required'=>'A {field} kitöltése kötelező!',
                        'alpha_numeric'=>'Csak betűt és számot írhat!',
                        'is_unique'=>'Ez a név már foglalt!'
                    ],
                ],
                'regpass'=>[
                    'label'=>'Jelszó',
                    'rules'=>'required|min_length[3]',
                    'errors'=>
                    [
                        'required'=>'A {field} kitöltése kötelező!',
                        'min_length'=>'Minimum 3 hosszú legyen!',
                    ],
                ],
            ]);
            if( $valid->withRequest($request)->run() === TRUE )
            {
                $inData = [
                    'u_name' => $posts['regname'],
                    'u_pass' => hash('SHA512', $posts['regpass']),
                ];
                if( $this->_authMdlObj->registrate($inData) === TRUE )
                {
                    print_r(json_encode(['success'=>'<div class="alert alert-success">A regisztráció sikeres! Most már beléphet.</div>'], JSON_UNESCAPED_UNICODE));
                }
            }
            else
            {
                $resp = 
                    [
                        'regname' => !empty($valid->getError('regname')) ? '<div class="alert alert-danger">'.$valid->getError('regname').'</div>' : '',
                        'regpass' => !empty($valid->getError('regpass')) ? '<div class="alert alert-danger">'.$valid->getError('regpass').'</div>' : '',
                    ];
                print_r(json_encode($resp, JSON_UNESCAPED_UNICODE));
            }
        }
        
    }
    
    
}
