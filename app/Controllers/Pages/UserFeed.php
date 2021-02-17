<?php

namespace App\Controllers\Pages;

use App\Controllers\MainCtrl;
use App\Controllers\Messaging;
use App\Models\UserFeedMdl;
use Config\Services;

class UserFeed extends MainCtrl{

    private $_uFeedMdlObj = '';
    
    public function __construct()
    {
        parent::__construct();
        $this->_uFeedMdlObj = new UserFeedMdl();
        
        if( $this->checkIsLogged() === FALSE )
        {
            header('Location: '.BASEURL.'/');
            exit();
        }
    }
    
    public function index()
    {
        $this->_data['uinfo'] = $this->sessObj->get('uinfo');
        
        $this->_data['rss_feeds'] = $this->_uFeedMdlObj->getUserFeeds($this->_data['uinfo']);
        if( !empty($this->_data['rss_feeds']) )
        {
            $rssFeedDatas = $this->getRssNewsInOrder($this->_data['rss_feeds']);
            $this->_data['rss_feed_datas'] = !empty($rssFeedDatas) ? $rssFeedDatas : '';
        }
        else
        {
            $this->_data['rss_feed_datas'] = '';
        }
        
        $this->_data['javascripts'] = [view($this->pagesPath.'/userFeed/js/userFeedJs')];//userFeedJs
        
        return view($this->pagesPath.'/userFeed/userFeed', $this->_data);
    }
    
    public function add()
    {
        $request = Services::request();
        $posts = $request->getPost();
        $msgr = new Messaging();
        
        $valid = Services::validation();
        $valid->setRules([
                'rss_url'=>[
                    'label'=>'RSS cím hozzáadása',
                    'rules'=>'required|valid_url|checkUserlinkUnique',//|is_unique[rss_infos.link]
                    'errors'=>
                    [
                        'required'=>'A {field} kitöltése kötelező!',
                        'valid_url'=>'Helytelen URL cím!',
                        'checkUserlinkUnique'=>'Ez a link már foglalt!!'
                    ],
                ],
            ]);
        if( $valid->withRequest($request)->run() === TRUE )
        {
            if($xmlres = $this->rssReader($posts['rss_url'], TRUE))
            {
                $inData = [
                    'user_id' => $this->sessObj->get('uinfo')['id'],
                    'link' => $posts['rss_url'],
                    'name' => $xmlres['title'],
                ];
                
                $this->_uFeedMdlObj->addUserFeed($inData);
                return redirect('userfeed');
            }
            else
            {
                $this->sessObj->setFlashdata('formError', $msgr->trowBackMsg( 'Nem megfelelő a cím!', 'danger') );
                return redirect('userfeed');
            }
        }
        else
        {
            $this->sessObj->setFlashdata('formError', $msgr->trowBackMsg($valid->getError('rss_url'), 'danger') );
            return redirect('userfeed');
        }
        
    }
    
    /**/
    public function delete( $id = FALSE )
    {
        if(is_numeric($id))
        {
            $deleteFeedInfo =
                    [
                        'id' => $id,
                        'user_id'=> $this->sessObj->get('uinfo')['id']
                    ];
            $this->_uFeedMdlObj->deleteUserFeed($deleteFeedInfo);
        }
        return redirect('userfeed');
    }
    
    private function getRssNewsInOrder(array $xmlLinkDataArr)
    {
        $result = [];
        foreach( $xmlLinkDataArr  as $rss_info )
        {
            $rssDatas =  $this->rssReader($rss_info['link']);
            $parsedUrl = parse_url($rssDatas['chlnk']);
            if(!empty($parsedUrl['host']))
            {
                $domainName = parse_url($rssDatas['chlnk'])['host'];

                foreach( $rssDatas['chdata'] as $itemArray )
                {
                    $itemArr = (array) $itemArray;

                    $date = new \DateTime($itemArr['pubDate']);
                    $dateFromated = $date->format('Y-m-d H:i:s');

                    $result[$domainName][$dateFromated] = $itemArr;
    //                $result[$domainName][strtotime($dateFromated)] = $itemArr;
                }
            }
            else
            {
                $result['errorRss'] = ['Hiba lekéréskor'];
                continue;
            }
        }
        // sorting 
        foreach($result as $resKey => $resArr)
        {
            uksort( $result[$resKey], [$this,'sortinByDateDESC']);
        }
        
        return $result;
    }
    
    
    private function sortinByDateASC($t1, $t2)
    {
        return $this->sortByDate($t1, $t2, FALSE);
    }
    private function sortinByDateDESC($t1, $t2)
    {
        return $this->sortByDate($t1, $t2, TRUE);
    }
    
    private function sortByDate($t1, $t2, $desc = TRUE)
    {
//        $t1Time = $t1;
//        $t2Time = $t2;
        $t1Time = strtotime($t1);
        $t2Time = strtotime($t2);
        if( $t1Time === $t2Time )
        {
            return 0;
        }
        
        if( $desc === TRUE)
        {
            return $t1Time < $t2Time ? 1 : -1;
        }
        else
        {
            return $t1Time > $t2Time ? 1 : -1;
        }
    }
    
    /**/
    private function rssReader(string $xmlLink, bool $shortInfo = FALSE)
    {
        if( $this->checkRSSXML($xmlLink) )
        {
            $xmlRes = (array) simplexml_load_file($xmlLink);
            $channel = (array) $xmlRes['channel'];
            if($shortInfo === TRUE)
            {
                return [
                    'title' => $channel['title'],
                    'link' => $channel['link'],
                ];  
            }
            else
            {
                return ['chlnk' => $channel['link'], 'chdata' => (array) $channel['item']];
            }
        }
        else
        {
            return FALSE;
        }
    }
    
    /**
     * @desc - checks if it's walid XML string
     * @param type $xmlLink
     * @return boolean
     */
    private function checkRSSXML(string $xmlLink)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $xmlLink);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        
        if(substr($output, 0, 5) == "<?xml")
        {
            return TRUE;
        } 
        else
        {
            return FALSE;
        }
    }

}