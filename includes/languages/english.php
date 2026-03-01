<?php
function lang($word){
    $lang = array(
        'HOME'     => 'Home',
        'DEFULET'     => 'Defulet',
        'STING'    => 'Sting',
        'SINOUT'   => 'Sing Out',
        'SINGIN'   => 'Sing In',
        'LOGIN'    => 'Log In',
        'ADMIN'    => 'Admin',
        'TO'       => 'To',
        //START NAV BAR KEY WORDS
        'LOGINOUT'   => ' Login out ',
        'SETTING'    => ' Setting ',
        'CATEGORIES' => ' Categoures ',
        'ITEMS' => ' itmes ',
        'MEBERS' => ' Mebers ',
        'STATISTICS' => ' Statistics ',
        'LOGS' => ' Logs ',
        'COMMENTER' => ' Commenter ',
        'EDITPROFILE'=> ' Edite Profile '
        // END  NAV BAR KEY WORDS

    );
    return $lang[$word];
}
?>