<?php

namespace App\Models\Admin\MessagesNotif;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\ClassesModel;
use CodeIgniter\Model;
use Config\Services;
 
class MessagesNotifModel extends Model {
  
  public function getLoadData($limit = 0, $offset = 0, $sort = 'ASC') {
    $getQuery = $this->db->table('messages')
      ->where(['action' => '0', 'reading_status' => '0'])
      ->orderBy('sendDate', strtoupper($sort))
      ->limit($limit, $offset);
    $result = $getQuery->get()->getResult(); 
    
    $length = $this->db->table('messages')
      ->where(['action' => '0', 'reading_status' => '0'])->countAllResults();
    
    $json = array(
      'aData' => $result,
      'length' => $length
    );

    return $json;
  }

}