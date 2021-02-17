<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Description of Auth -  kezeli az authentikációs adatbázis hívásokat
 */
class AuthMdl extends Model {
    
    protected $table = 'users';


    public function __construct() {
        parent::__construct();
    }
    
    public function registrate($inDataArr) 
    {
        $builder =  $this->db->table($this->table);
        $res = $builder->insert($inDataArr);
        return $res->resultID;
    }
    
    public function loginTry($inDataArr)
    {
        $builder =  $this->db->table($this->table);
        $builder->select('id, u_name');
        $builder->where('u_name', $inDataArr['u_name']);
        $builder->where('u_pass', $inDataArr['u_pass']);
        $result = $builder->get();
        
        if( $result->getNumRows() == 1)
        {
            return $result->getRowArray();
        }
        return FALSE;
        
    }
    
}
