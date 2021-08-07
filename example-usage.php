<?php
header('Content-Type: application/json');
require 'Atl-Group.php';

$AtlGroup = new AtlGroup(
    [
        'api_id' => '', // YOUR API ID
        'api_key' => '', // YOUR API KEY
        'subs_id' => [
            'whatsapp' => '', // YOUR SUBSCRIPTION ID WHATSAPP (OPTIONAL)
            'mutasi' => '' // YOUR SUBSCRIPTION ID MUTASI (OPTIONAL)
        ]
    ]
);

print json_encode($AtlGroup->GameValidator('Mobile Legends', '50366399', '2004'), JSON_PRETTY_PRINT);
