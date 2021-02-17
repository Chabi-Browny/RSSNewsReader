<?php

namespace App\Models;

use CodeIgniter\Model;

class UserFeedMdl extends Model{
    
    protected $table = 'rss_infos';

    public function __construct() {
        parent::__construct();
    }
    
    /**/
    public function getUserFeeds($userInfoArr, $justLinks=FALSE)
    {
        $build = $this->db->table($this->table);
        if($justLinks === TRUE)
        {
            $build->select($this->table.'.link');
        }
        else
        {
            $build->select($this->table.'.id,'.$this->table.'.name,'.$this->table.'.link');
        }
        $build->join('users','users.id = '.$this->table.'.user_id');
        $build->where('users.id',$userInfoArr['id']);
        $build->where('users.u_name',$userInfoArr['u_name']);
        $res = $build->get();
        if( $res->getNumRows() > 0 )
        {
            if($justLinks === TRUE)
            {
                $resultLinks = [];
                foreach($res->getResultArray() as $res)
                {
                    $resultLinks[] = $res['link'];
                }
                return $resultLinks;
            }
            else
            {
                return $res->getResultArray();
            }
        }
    }
    
    /**/
    public function addUserFeed($inDataArr)
    {
        $builder =  $this->db->table($this->table);
        $res = $builder->insert($inDataArr);
        return $res->resultID;
    }
    
    /**/
    public function deleteUserFeed($feedInfoArr)
    {
        $build = $this->db->table($this->table);
        $build->where('id',$feedInfoArr['id'])
              ->where('user_id', $feedInfoArr['user_id'])
              ->delete();
    }

}