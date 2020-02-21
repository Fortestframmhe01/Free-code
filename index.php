<?php

define('AUTO_FILE', 'หน้าหลัก');
define('FILE_EXTEND', 'rmk');

function _readphp_eval($code) {
    ob_start();
    print eval('?>'. $code);
    $output = ob_get_contents();
    ob_end_clean();
    
    return $output;
}

function _convert($data) {
    $content = $data;

    /**
     * @ รูปแบบโค้ดของคุณ
     */
    $content = str_replace('เริ่มโปรแกรม', '<?php', $content);
    $content = str_replace('จบโปรแกรม', '?>', $content);
    $content = str_replace('จบ', '";', $content);
    $content = str_replace(' จบ', '";', $content);
    $content = str_replace('พูด', 'echo ', $content);
    $content = str_replace('พูด ', 'echo ', $content);
    $content = str_replace('ว่า ', '"', $content);
    $content = str_replace('จบ', '"', $content);
    $content = str_replace('ตัวแปร ', '$', $content);
    $content = str_replace('ตัวแปร', '$', $content);
    $content = str_replace('.', '->', $content);
    $content = str_replace('สร้างคลาส ', 'new ', $content);
    $content = str_replace('อ็อบเจ็กต์', 'class ', $content);
    $content = str_replace('ฟังก์ชั่นสาธารณะ', 'public function ', $content);
    $content = str_replace('ฟังก์ชั่น', 'function ', $content);
    $content = str_replace('โกลบัล', 'global ', $content);
    

    return $content;
}

global $sendParams;

if(isset($_SERVER['PATH_INFO'])) {
    if(count(explode('/', $_SERVER['PATH_INFO'])) > 1) {
        $urlInput = explode('/', $_SERVER['PATH_INFO']);
        array_shift($urlInput);
        array_shift($urlInput);

        $sendParams = $urlInput;
    }
}

class RmkLang {
    public $_fileAction, $dataOfFile;

    public function __construct() {
        if(isset($_SERVER['PATH_INFO'])) {
            $getUrl = explode('/', $_SERVER['PATH_INFO']);
            array_shift($getUrl);
            $this->_fileAction = $getUrl[0];

            if(file_exists('app/' . $this->_fileAction . '.' . FILE_EXTEND)) {
                ob_start();
                include('app/' . $this->_fileAction . '.' . FILE_EXTEND);
                $this->dataOfFile = ob_get_clean();
                $content = _convert($this->dataOfFile);
                echo _readphp_eval($content);
            }
        } else {
            if(file_exists('app/' . AUTO_FILE . '.' . FILE_EXTEND)) {
                ob_start();
                include('app/' . AUTO_FILE . '.' . FILE_EXTEND);
                $this->dataOfFile = ob_get_clean();
                $content = _convert($this->dataOfFile);
                echo _readphp_eval($content);
            }
        }
    }
}

new RmkLang();