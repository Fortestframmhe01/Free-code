<?php

define('AUTO_FILE', 'หน้าหลัก'); // ไฟล์หลัก
define('FILE_EXTEND', 'rmk'); // นามสกุลไฟล์

function _readphp_eval($code) { // ฟังก์ชั่นอ่าน PHP
    ob_start();
    print eval('?>'. $code);
    $output = ob_get_contents();
    ob_end_clean();
    
    return $output;
}

function _convert($data) { // ฟังก์ชั่นเปลี่ยนรูปแบบโค้ด ให้มาอยู่ในรูปแบบที่ถูกต้องของภาษา PHP
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

global $sendParams; // ตัวแปรที่จะส่งค่าไปให้ไฟล์ โปรแกรมของเรา

if(isset($_SERVER['PATH_INFO'])) { // ตรวจสอบ Path
    if(count(explode('/', $_SERVER['PATH_INFO'])) > 1) {
        $urlInput = explode('/', $_SERVER['PATH_INFO']);
        array_shift($urlInput); // ถ้าเป็นเซิฟเวอร์จริง ให้ลบ array_shift ออก 1 ตัว
        array_shift($urlInput);

        $sendParams = $urlInput;
    }
}

class RmkLang {
    public $_fileAction, $dataOfFile;

    public function __construct() {
        if(isset($_SERVER['PATH_INFO'])) {
            $getUrl = explode('/', $_SERVER['PATH_INFO']);
            array_shift($getUrl); // ถ้าใช้เซิฟเวอร์จริง ให้ลบบรรทัดนี้ออกได้เลย 
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
