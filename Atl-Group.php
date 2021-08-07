<?php
class AtlGroup
{
    private $id;
    private $key;
    private $sid;

    /**
     * 
     * Class For Atlantic Group
     * @param string $id YOUR API ID
     * @param string $key YOUR API KEY
     * @param array $sid ['whatsapp' => 'your sid', 'mutasi' => 'your sid']
     * 
     */

    public function __construct($id, $key, $sid)
    {
        $this->id        = $id;
        $this->key       = $key;
        $this->sid       = $sid;
        $this->sign      = md5($this->id . $this->key);
        $this->base      = 'https://atlantic-group.co.id/api/v1/';
        $this->end_point = [
            'whatsapp' => 'whatsapp',
            'mutasi' => 'mutasi/',
            'game' => 'game-validation'
        ];
    }

    private function connect($_ENDPOINT, $_PARAM, $_SID = NULL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $_PARAM['key'] = $this->key;
        $_PARAM['sid'] = $_SID;
        $_PARAM['sign'] = $this->sign;
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_PARAM));
        curl_setopt($ch, CURLOPT_URL, $this->base . $_ENDPOINT);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    ####################################################
    ##################### WHATSAPP #####################

    /**
     * 
     * @param string $_TYPE send-message : For Send Message
     * @param string $_TYPE send-file : For Send File
     * @param string $_TYPE send-location : For Send Location
     * @param string $_TYPE add-user : For Add User
     * @param string $_TYPE remove-user : For Remove User
     * @param string $_TYPE update-group-name : For Update Group Name
     * @param string $_TYPE update-group-desc : For Update Group Desc
     * @param array $_DATA ['081210110328', 'Hallo Sir'] ex For Send Message
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
                $_PARAM = [
                    'type' => 'add_user',
                    'phone' => $_DATA[0],
                    'message' => $_DATA[1],
                    'users' => $_DATA[2]
                ];
                break;

            case 'remove-user':
                $_PARAM = [
                    'type' => 'remove_user',
                    'phone' => $_DATA[0],
                    'message' => $_DATA[1],
                    'users' => explode(',', $_DATA[2])[0]
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
     * @param string $_TYPE info : Get Information Bank Account
     * @param string $_TYPE bca : Get BCA Mutation
     * @param string $_TYPE bni : Get BNI Mutation
     * @param string $_TYPE gopay : Get GOPAY Mutation
     * @param string $_TYPE ovo : Get OVO Mutation
     * @param array $_DATA [10] ex To Get GOPAY/OVO Mutation With Limit 10 
     * @return array
     * 
     */

    public function Mutasi($_TYPE, $_DATA = NULL)
    {
        switch ($_TYPE) {
            case 'info':
                $_BANK      = strtoupper($_DATA[0]);
                $_ENDPOINT  = 'info';
                if (in_array($_BANK, ['BCA', 'BNI', 'GOPAY', 'OVO'])) {
                    $_PARAM = [
                        'payment' => $_BANK
                    ];
                    return $this->connect($this->url . '/mutasi/info', ['payment' => $_BANK]);
                } else {
                    $_PARAM = $_DATA;
                }
                break;

            case 'BCA':
                $_ENDPOINT  = 'bca';
                $_PARAM = [
                    'from_date' => $_DATA[0],
                    'to_date' => $_DATA[1],
                    'quantity' => $_DATA[2],
                    'description' => $_DATA[3]
                ];
                break;

            case 'BNI':
                $_ENDPOINT  = 'bni';
                $_PARAM = [
                    'from_date' => $_DATA[0],
                    'to_date' => $_DATA[1],
                    'quantity' => $_DATA[2],
                    'description' => $_DATA[3]
                ];
                break;

            case 'GOPAY':
                $_ENDPOINT  = 'gopay';
                $_PARAM = [
                    'limit' => $_DATA[0],
                    'quantity' => isset($_DATA[1]) ? $_DATA[1] : NULL,
                    'description' => isset($_DATA[1]) ? $_DATA[2] : NULL
                ];
                break;

            case 'OVO':
                $_ENDPOINT  = 'ovo';
                $_PARAM = [
                    'limit' => $_DATA[0],
                    'quantity' => isset($_DATA[1]) ? $_DATA[1] : NULL,
                    'description' => isset($_DATA[1]) ? $_DATA[2] : NULL
                ];
                break;

            default:
                NULL;
                break;
        }

        return $this->connect($this->end_point['mutasi'] . '/' . $_ENDPOINT, $_PARAM, $this->sid['mutasi']);
    }

    ####################################################
    ################## GAME VALIDATOR ##################

    /**
     * 
     * Check Valid Nickname By Player ID
     * @param string $game Type Of Game ex Mobile Legends
     * @param string $id Your Player ID
     * @param mixed|null $zone Set NULL If Don't Have Zone or Server ID
     * 
     */

    public function GameValidator($game, $id, $zone = NULL)
    {
        $data['game']   = $game;
        $data['id']     = $id;
        if ($zone !== NULL) $data['zone'] = $zone;
        return $this->connect($this->end_point['game'], $data);
    }
}
