<?php

/********************************************************************************************* 
 * @script          Atlantic Group Library
 * @description     PHP Library To Interact With All APIs From https://atlantic-group.co.id/
 * @version         1.0.0
 * @release         August 07 2021
 * @update          ---
 * @author          Rifqi Galih Nur Ikhsan (RGSann)
 * @email           rgsanstuy@gmail.com
 * @instagram       rgsannn
 * 
 * @copyright       Copyright © 2021, Rifqi Galih Nur Ikhsan. All Rights Reserved.
 * 
 *********************************************************************************************/

class AtlGroup
{
    private $id;
    private $key;
    private $sid;

    /**
     * 
     * Class For Atlantic Group
     * @param array $_ATL
     * 
     */

    public function __construct($_ATL)
    {
        $this->id        = $_ATL['api_id'];
        $this->key       = $_ATL['api_key'];
        $this->sid       = $_ATL['subs_id'];
        $this->sign      = md5($this->id . $this->key);
        $this->base      = 'https://atlantic-group.co.id/api/v1/';
        $this->end_point = [
            'whatsapp' => 'whatsapp',
            'mutasi' => 'mutasi/',
            'game' => 'game-validation'
        ];
    }

    ####################################################
    ##################### WHATSAPP #####################

    /**
     * 
     * @param string $_TYPE
     * @param array $_DATA
     * @return array
     * 
     */

    public function Whatsapp($_TYPE, $_DATA)
    {
        switch ($_TYPE) {
            case 'send-message':
                $_PARAM = [
                    'type' => 'message',
                    'phone' => $_DATA[0],
                    'message' => $_DATA[1]
                ];
                break;

            case 'send-file':
                $_PARAM = [
                    'type' => 'file',
                    'phone' => $_DATA[0],
                    'filetype' => $_DATA[1],
                    'source' => base64_encode(file_get_contents($_DATA[2])),
                    'message' => $_DATA[3]
                ];
                break;

            case 'send-location':
                $_PARAM = [
                    'type' => 'file',
                    'phone' => $_DATA[0],
                    'latitude' => $_DATA[1],
                    'longtitude' => $_DATA[2],
                    'message' => $_DATA[3]
                ];
                break;

            case 'add-user':
            case 'remove-user':
                $_PARAM = [
                    'type' => str_replace('-', '_', $_TYPE),
                    'phone' => $_DATA[0],
                    'message' => $_DATA[1],
                    'users' => $_DATA[2]
                ];
                break;

            case 'update-group-name':
                $_PARAM = [
                    'type' => 'update_subject',
                    'phone' => $_DATA[0],
                    'message' => $_DATA[1]
                ];
                break;

            case 'update-group-desc':
                $_PARAM = [
                    'type' => 'update_description',
                    'phone' => $_DATA[0],
                    'message' => $_DATA[1]
                ];
                break;

            default:
                NULL;
                break;
        }

        return $this->connect($this->end_point['whatsapp'], $_PARAM, $this->sid['whatsapp']);
    }

    ####################################################
    ###################### MUTASI ######################

    /**
     * 
     * @param string $_TYPE
     * @param array $_DATA
     * @return array
     * 
     */

    public function Mutasi($_TYPE, $_DATA = [])
    {
        $_TYPE = strtoupper($_TYPE);
        switch ($_TYPE) {
            case 'info':
                $_BANK      = strtoupper($_DATA);
                $_PARAM     = NULL;
                if (in_array($_BANK, ['BCA', 'BNI', 'GOPAY', 'OVO'])) $_PARAM = ['payment' => $_BANK];
                break;

            case 'bca':
            case 'bni':
                $_PARAM = [
                    'from_date' => $this->setNull($_DATA[0]),
                    'to_date' => $this->setNull($_DATA[1]),
                    'quantity' => $this->setNull($_DATA[2]),
                    'description' => $this->setNull($_DATA[3])
                ];
                break;

            case 'gopay':
            case 'ovo':
                $_PARAM = [
                    'limit' => $this->setNull($_DATA[0]),
                    'quantity' => $this->setNull($_DATA[1]),
                    'description' => $this->setNull($_DATA[2])
                ];
                break;

            default:
                NULL;
                break;
        }

        return $this->connect($this->end_point['mutasi'] . '/' . $_TYPE, $_PARAM, $this->sid['mutasi']);
    }

    ####################################################
    ################## GAME VALIDATOR ##################

    /**
     * 
     * Check Valid Nickname By Player ID
     * @param string $_GAME Type Of Game ex Mobile Legends
     * @param string $_UID Your Player ID
     * @param mixed|null $_ZONEID Set NULL If Don't Have Zone or Server ID
     * 
     */

    public function GameValidator($_GAME, $_UID, $_ZONEID = NULL)
    {
        $_PARAM['game']   = $_GAME;
        $_PARAM['id']     = $_UID;
        if ($_ZONEID !== NULL) $_PARAM['zone'] = $_ZONEID;
        return $this->connect($this->end_point['game'], $_PARAM);
    }

    // ShennBoku Writer This Function connect() //
    private function connect($_ENDPOINT, $_PARAM, $_SID = NULL)
    {
        $_PARAM['key'] = $this->key;
        $_PARAM['sid'] = $_SID;
        $_PARAM['sign'] = $this->sign;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_PARAM));
        curl_setopt($ch, CURLOPT_URL, $this->base . $_ENDPOINT);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $chresult = curl_exec($ch);
        curl_close($ch);
        return json_decode($chresult, true);
    }

    private function setNull($_DATA)
    {
        return isset($_DATA) ? $_DATA : NULL;
    }
}
