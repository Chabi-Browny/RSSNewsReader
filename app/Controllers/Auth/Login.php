<?php

namespace App\Controllers\Auth;

use App\Controllers\MainCtrl;
use App\Models\AuthMdl;
use Config\Services;
/**
 * Description of Login
 */
class Login extends MainCtrl{
    
    private $_authMdlObj = '';
    
    public function __construct() 
    {
        parent::__construct();
        $this->_authMdlObj = new AuthMdl();
    }
    
    public function login()
    {
        $request = Services::request();
        $userSess = $this->sessObj->get('uinfo');
        if( $request->isAJAX() === TRUE )
        {
            if( !isset($userSess)  )
            {
                $valid = Services::validation();
                $posts = $request->getPost();

                $valid->setRules([
                    'logname'=>[
                        'label'=>'Felhasználó név',
                        'rules'=>'required|alpha_numeric',
                        'errors'=>
                        [
                            'required'=>'A {field} kitöltése kötelező!',
                            'alpha_numeric'=>'Csak betűt és számot írhat!',
                        ],
                    ],
                    'logpass'=>[
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
                        'u_name' => $posts['logname'],
                        'u_pass' => hash('SHA512', $posts['logpass']),
                    ];
                    $logResult = $this->_authMdlObj->loginTry($inData);
                    if( $logResult !== FALSE)
                    {
                        $this->sessObj->set(['uinfo'=>$logResult]);
                        print_r(json_encode(['success'=>'<div class="alert alert-success">Sikeres belépés.</div>'], JSON_UNESCAPED_UNICODE));
                    }
                    else
                    {
                        print_r(json_encode(['fail' => '<div class="alert alert-danger">Helytelen jelszó vagy felhasználó</div>' ], JSON_UNESCAPED_UNICODE));
                    }
                }
                else
                {
                    $resp = 
                        [
                            'logname' => !empty($valid->getError('logname')) ? '<div class="alert alert-danger">'.$valid->getError('logname').'</div>' : '',
                            'logpass' => !empty($valid->getError('logpass')) ? '<div class="alert alert-danger">'.$valid->getError('logpass').'</div>' : '',
                        ];
                    print_r(json_encode($resp, JSON_UNESCAPED_UNICODE));
                }
            }
            else
            {
                //ha be van loggolva visszairányít a feedre
                print_r(json_encode('logged', JSON_UNESCAPED_UNICODE));
            }
        }
        else
        {
            return redirect('/');
        }
    }
    
    public function logout()
    {
        $this->sessObj->destroy();
        return redirect('/');
    }
    
}