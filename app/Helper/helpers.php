<?php

use Illuminate\Support\Facades\{DB, Storage, Mail, Exception, Queue,Log};
use App\Jobs\SendActionMails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\User;
use App\Notifications\SendNotification;
use Smalot\PdfParser\Parser;


if (!function_exists('getData')) {
    function getData($table, $select, $where = '', $limit = '', $order_col = '', $order_dirc = 'DESC')
    {
        if (isset($table) && !empty($table) && isset($select) && is_array($select) && isset($where) && is_array($where)) {
            // $query = DB::table($table)->select($select)->where('is_deleted', 'No'); OLD
            $query = DB::table($table)->select($select); //New
            if (isset($where) && !empty($where) && $where != '' &&  is_array($where)) {
                $query->where($where);
            }
            if (isset($limit) && !empty($limit) && is_numeric($limit) && $limit != '') {
                $query->limit($limit);
            }
            if (isset($order_col) && !empty($order_col)) {
                $query->orderBy($order_col, $order_dirc);
            }

            $data = $query->get();
            return $data;
        }
    }
}
if (!function_exists('is_exist')) {
    function is_exist($table, $where)
    {
        $data = 0;
        if (isset($table) && !empty($table) && isset($where) && is_array($where)) {
            $data = DB::table($table)->where($where)->count();
        }
        return $data;
    }
}
if (!function_exists('processData')) {
    function processData($tableInfo, $data = [], $where = [])
    {

        $exists = 0;
        if (count($where) > 0) {
            $exists =  is_exist($tableInfo[0], $where);
        }
        if (isset($tableInfo) && is_array($tableInfo) && count($tableInfo) === 2) {
            $query = DB::table($tableInfo[0]);
            $primarykeyCol = isset($tableInfo[1])  ? $tableInfo[1] : 0;
          
            if (isset($exists) && is_numeric($exists) && $exists === 0) {
                if (isset($data) && is_array($data) && count($data) > 0) {
                    $getId =  $query->insertGetId($data);
                    if (isset($getId) && is_numeric($getId) && $getId > 0) {
                        return ['status' => TRUE, 'id' => $getId];
                    }
                }
                return FALSE;
            } elseif (isset($exists) && is_numeric($exists) && $exists > 0) {
                if (isset($where) && is_array($where) && count($where) > 0) {
                    $query->where($where);
                }
                $getId = $query->first($primarykeyCol)->$primarykeyCol;
                if (isset($data) && is_array($data) && count($data) > 0) {
                    $response = $query->update($data);
                    if (isset($response) && is_numeric($response)) {
                        return ['status' => TRUE, 'id' => $getId];
                    }
                }
                return FALSE;
            }
            return FALSE;
        }
        return FALSE;
    }
}

if (!function_exists('UploadFiles')) {
    function UploadFiles($file, $folder, $old_file = '')
    {
        if (isset($file) && !empty($file) && isset($folder) && !empty($folder)) {
            //$filename = rand() . '.' . $file->getClientOriginalName(); 
            
            $is_uploaded = Storage::disk('public')->putFile($folder, $file);
            if (isset($is_uploaded) && !empty($is_uploaded)) {
                if (!empty($old_file) && isset($old_file) && Storage::disk('public')->exists($old_file)) {
                    Storage::disk('public')->delete($old_file);
                }
                 die;
                return ['status' => TRUE, 'url' => $is_uploaded];
            } else {
                return FALSE;
            }
        } else {

            return FALSE;
        }
    }
}
if (!function_exists('mail_send')) {
    function mail_send($tmpl_id, $repl_contain, $repl_value, $sendto,$sendcc=[],$replayto=[])
    {
       
        
        $templContain = getData('email_templates', ['email_subject', 'email_content'], ['is_deleted' => 'No', 'id' => $tmpl_id]);
       
        $email_subject = $templContain[0]->email_subject;
        $email_content = $templContain[0]->email_content;
        $data['newSubject'] = str_replace($repl_contain, $repl_value, $email_subject);
        $data['newContain'] = str_replace($repl_contain, $repl_value, $email_content);
       
        $tes = send(
            $data['newSubject'],
            $data['newContain'],
            $sendto,
            $sendcc,
            $replayto,         
        );
       

    }
}
if (!function_exists('send')) {
    function send($subject, $sendingData, $sendto,$sendcc = [],$replayto=[])
    {
        
        try {
            Queue::push(new SendActionMails($subject, $sendingData, $sendto,$sendcc,$replayto));
            return TRUE;
        } catch (\Exception $error) {
            return FALSE;
        }
    }
}