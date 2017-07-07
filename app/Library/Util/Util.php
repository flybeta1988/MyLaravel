<?php

/**
 * 扩展功能函数类
 */
class Util {

    /**
     * 能自动去除空元素explode
     *
     * @return array
     */
    public static function explode($seperator, $str) {
        $ret = array();
        if (!$str) {
            $str = '';
        }
        $str = (string)$str;
        if ($str !== '') {
            $result = explode($seperator, $str);
            foreach ($result as $_str) {
                if ($_str === '') {
                    continue;
                }
                $ret[] = $_str;
            }
        }
        return $ret;
    }

    /**
     * 获取文件扩展名
     *
     * @param String $val
     * @return String
     */
    public static function getFileExtName($fn) {
        $ext = (string)substr(strrchr($fn, '.'), 1);
        if (($pos = strpos($ext, '?')) === false) {
            return $ext;
        }
        return (string)substr($ext, 0, $pos);
    }

    /**
     * 获取文件第一个. 之后的名字
     *
     * @param String $val
     * @return String
     */
    public static function getFileFirstExtName($fn) {
        return substr($fn, strpos($fn, '.') + 1);
    }

    /**
     * 获取不包括扩展名（也不包括点）的文件名
     */
    public static function basename($fn) {
        $pos = strpos($fn, '.');
        if ($pos) {
            return substr($fn, 0, $pos);
        }
        return $fn;
    }

    /**
     * 得到当前用户Ip地址
     *
     * @return string
     */
    public static function getRealIp() {
        $pattern = '/(\d{1,3}\.){3}\d{1,3}/';
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && preg_match_all($pattern, $_SERVER['HTTP_X_FORWARDED_FOR'], $_mat)) {
            foreach ($_mat[0] as $_ip) {
                //得到第一个非内网的IP地址
                if ((0 != strpos($_ip, '192.168.')) && (0 != strpos($_ip, '10.')) && (0 != strpos($_ip, '172.16.'))) {
                    return $_ip;
                }
            }
        } else {
            if (isset($_SERVER["HTTP_CLIENT_IP"]) && preg_match($pattern, $_SERVER["HTTP_CLIENT_IP"])) {
                return $_SERVER["HTTP_CLIENT_IP"];
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    }

    /**
     * 得到无符号整数表示的ip地址
     */
    public static function getIntIp() {
        return sprintf('%u', ip2long(self::getRealIp()));
    }

    /*
     * 过滤逗号分割的 id 字符串，转换全角字符为半角，去除可能的手误字符
     */
    public static function filterIdStr($idStr) {
        $idStr = trim(self::qj2bj($idStr));
        $intAry = str_split($idStr);
        $ret = array();
        foreach ($intAry as $char) {
            if (is_numeric($char) || $char === ',') {
                $ret[] = $char;
            }
        }
        return trim(join('', $ret), ',');
    }

    /**
     * 取合法的 id 字符串或 id 数组
     */
    public static function getValidId($oIdStr, $resultType = 'string') {
        //排除部分手误影响
        $oIdStr = self::filterIdStr($oIdStr);
        while (false !== strpos($oIdStr, ',,')) {
            $oIdStr = str_replace(',,', ',', $oIdStr);
        }
        $idAry = array_unique(self::explode(',', $oIdStr));
        return ($resultType == 'string') ? join(',', $idAry) : $idAry;
    }

    public static function mkHashDir($basedir, $num = 100) {
        $l = 0;
        for ($i = 0; $i < $num; $i++) {
            for ($j = 0; $j < $num; $j++) {
                $dir = $basedir . $i . '/' . $j . '/';
                mkdir($dir, 0777, true);
                $l++;
            }
        }
        return $l;
    }

    public static function getHashDir($num = 100, $level = 2) {
        $hash_path = '/';
        for ($i = 0; $i < $level; $i++) {
            $hash_path .= mt_rand(1, $num) . '/';
        }
        return $hash_path;
    }

    //生成一个17字节长唯一随机文件名
    public static function getRandFileName() {
        return chr(mt_rand(97, 122)) . mt_rand(10000, 99999) . time();
    }

    /**
     * 输入一个秒数，返回时分秒格式的字符串
     *
     * @param int $secs
     * @return string
     */
    public static function secToTime($secs) {
        if ($secs < 3600) {
            return sprintf("%02d:%02d", floor($secs / 60), $secs % 60);
        }
        $h = floor($secs / 3600);
        $m = floor(($secs % 3600) / 60);
        $s = $secs % 60;
        return sprintf("%02d:%02d:%02d", $h, $m, $s);
    }

    /**
     * 全角 => 半角, 默认不转符号。
     *
     * @param string $string
     * @return string
     */
    public static function qj2bj($string, $symbol = false) {
        $convert_table = [
            '０' => '0',
            '１' => '1',
            '２' => '2',
            '３' => '3',
            '４' => '4',
            '５' => '5',
            '６' => '6',
            '７' => '7',
            '８' => '8',
            '９' => '9',
            'Ａ' => 'A',
            'Ｂ' => 'B',
            'Ｃ' => 'C',
            'Ｄ' => 'D',
            'Ｅ' => 'E',
            'Ｆ' => 'F',
            'Ｇ' => 'G',
            'Ｈ' => 'H',
            'Ｉ' => 'I',
            'Ｊ' => 'J',
            'Ｋ' => 'K',
            'Ｌ' => 'L',
            'Ｍ' => 'M',
            'Ｎ' => 'N',
            'Ｏ' => 'O',
            'Ｐ' => 'P',
            'Ｑ' => 'Q',
            'Ｒ' => 'R',
            'Ｓ' => 'S',
            'Ｔ' => 'T',
            'Ｕ' => 'U',
            'Ｖ' => 'V',
            'Ｗ' => 'W',
            'Ｘ' => 'X',
            'Ｙ' => 'Y',
            'Ｚ' => 'Z',
            'ａ' => 'a',
            'ｂ' => 'b',
            'ｃ' => 'c',
            'ｄ' => 'd',
            'ｅ' => 'e',
            'ｆ' => 'f',
            'ｇ' => 'g',
            'ｈ' => 'h',
            'ｉ' => 'i',
            'ｊ' => 'j',
            'ｋ' => 'k',
            'ｌ' => 'l',
            'ｍ' => 'm',
            'ｎ' => 'n',
            'ｏ' => 'o',
            'ｐ' => 'p',
            'ｑ' => 'q',
            'ｒ' => 'r',
            'ｓ' => 's',
            'ｔ' => 't',
            'ｕ' => 'u',
            'ｖ' => 'v',
            'ｗ' => 'w',
            'ｘ' => 'x',
            'ｙ' => 'y',
            'ｚ' => 'z',
            '＃' => '#',
            '＠' => '@',
            '＊' => '*',
            '　' => ' ',
        ];

        $symbol_table = [
            '／' => '/',
            '：' => ':',
            '。' => '.',
            '？' => '?',
            '！' => '!',
            '，' => ',',
            '；' => ';',
            '［' => '[',
            '］' => ']',
            '｜' => '|',
            '－' => '-',
        ];
        return strtr($string, $symbol ? $convert_table + $symbol_table : $convert_table);
    }

    /**
     *
     *  将windows下非法文件字符转成全角
     * @param string $string
     * @return string
     */
    public static function bj2qj($string) {
        $convert_table = [
            '/' => '／',
            '\\' => '＼',
            ':' => '：',
            '*' => '＊',
            '?' => '？',
            '"' => '＂',
            '<' => '＜',
            '>' => '＞',
            '|' => '｜',
        ];
        return strtr($string, $convert_table);
    }

    /**
     * 对一个二维数组自定义排序
     *
     * @param array $ary
     * @param string $compareField
     * @param string $seq = 'DESC'|'ASC'
     * @param int $sortFlag = SORT_NUMERIC | SORT_REGULAR | SORT_STRING | SORT_NATURAL
     * @return array
     */
    public static function sort(&$ary, $compareField, $seq = 'DESC', $sortFlag = SORT_NATURAL) {
        $sortData = array();
        foreach ($ary as $key => $value) {
            $sortData[$key] = isset($value[$compareField]) ? $value[$compareField] : '';
        }

        if ($seq == 'DESC') {
            arsort($sortData, $sortFlag);
        } else {
            asort($sortData, $sortFlag);
        }

        $ret = array();
        foreach ($sortData as $key => $value) {
            $ret[$key] = $ary[$key];
        }

        $ary = $ret;
        return $ary;
    }

    public static function natsort(&$ary, $compareField) {
        $sortData = array();
        foreach ($ary as $key => $value) {
            $sortData[$key] = $value[$compareField];
        }
        natcasesort($sortData);

        $ret = array();
        foreach ($sortData as $key => $value) {
            $ret[$key] = $ary[$key];
        }
        $ary = $ret;
        return $ary;
    }

    public static function getSessionMsg() {
        if (isset($_SESSION['__message__']) && ($msg = $_SESSION['__message__'])) {
            unset($_SESSION['__message__']);
        } else {
            $msg = '';
        }
        return $msg;
    }

    public static function sessionMsgRedirect($msg, $url = '') {
        $_SESSION['__message__'] = $msg;
        self::redirect($url);
    }

    public static function redirect($url = '') {
        if (self::is_ajax_request()) {
            exit(json_encode(array('errcode' => 1, 'msg' => '发生了意外的错误')));
        }
        if ($url === '') {
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
                $url = $_SERVER['HTTP_REFERER'];
            } else {
                $url = '/';
            }
        }
        header("Location: {$url}");

        ob_clean();

        exit;
    }

    //判断是否是ajax请求
    public static function is_ajax_request() {
        return from_ajax() || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    public static function getCookieDomain() {
        $fn = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        $f = explode('.', $fn);
        if (isset($f[0], $f[1]) && ctype_digit($f[0]) && ctype_digit($f[1])) { //IP
            if (isset($f[3]) && false !== ($pos = stripos($f[3], ':'))) {
                $f[3] = substr($f[3], 0, $pos);
            }
            return join('.', $f);
        } elseif (strpos($fn, '.') === false) { //机器名
            if (false !== ($pos = stripos($fn, ':'))) {
                return substr($fn, 0, $pos);
            }
            return $fn;
        } else {
            $snippet_count = sizeof($f);
            //去掉可能存在的端口号部分
            $last_par_index = $snippet_count - 1;
            if (isset($f[$last_par_index]) && false !== ($pos = stripos($f[$last_par_index], ':'))) {
                $f[$last_par_index] = substr($f[$snippet_count - 1], 0, $pos);
            }
            return '.' . join('.', $f);
        }
    }

    public static function setCookie($name, $value, $life = 0, $path = '/', $httponly = false) {
        $domain = self::getCookieDomain();
        return @setcookie($name, $value, $life, $path, $domain, $_secure = false, $httponly);
    }

    /**
     * 文本入库前的过滤工作
     */
    public static function getSafeText($textString, $qj2bj = true, $htmlspecialchars = true, $striptags = true) {
        if ($qj2bj) {
            $textString = self::qj2bj($textString);
        }

        if ($striptags) {
            $textString = strip_tags($textString);
        }

        if ($htmlspecialchars) {
            $textString = Util::htmlspecialchars($textString);
        }
        return trim(self::getSafeUtf8($textString));
    }

    public static function getSafeXml($string) {
        return self::getSafeUtf8(trim(self::qj2bj($string)));
    }

    public static function getSafeUtf8($content) {
        return mb_convert_encoding($content, 'utf-8', 'utf-8');
    }

    public static function debug($logFile = '') {
        if (!$logFile) {
            $logFile = '/tmp/debug.log';
        }
        $fp = fopen('php://stdout', 'w');

        static $__start_time = NULL;
        static $__start_code_line = 0;
        $dtrace = debug_backtrace();
        $call_info = array_shift($dtrace);
        $code_line = $call_info['line'];
        $fileAry = explode('/', $call_info['file']);
        $file = array_pop($fileAry);

        if ($__start_time === NULL) {
            $str = "debug " . $file . "> initialize\n";
            fputs($fp, $str);
            self::log($str, $logFile);
            $__start_time = microtime(true);
            $__start_code_line = $code_line;
            fclose($fp);
        } else {
            $str = sprintf("debug %s> code-lines: %d-%d time: %.4f mem: %d KB\n", $file, $__start_code_line, $code_line, (microtime(true) - $__start_time), /*ceil( memory_get_usage()/1024)*/
                0);
            fputs($fp, $str);
            fclose($fp);
            self::log($str, $logFile);
            $__start_time = microtime(true);
            $__start_code_line = $code_line;
        }
    }

    public static function msgRedirect($message_text, $url = '', $type = 'message', $seconds = 3) {
        // 如果是ajax访问，走这里
        if (self::is_ajax_request()) {
            exit(json_encode(array('errcode' => 1, 'msg' => self::htmlspecialchars($message_text))));
        }
        if (!$url) {
            $url = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        }

        $url = get_safe_url($url);
        $time = $seconds * 1000;
        self::outputExpireHeader(-86400);

        $newclass = 'tips';
        $tips_txt = '系统';
        if ($type == 'error') {
            $newclass = 'error';
            $tips_txt = '错误';
        } else if ($type == 'warning') {
            $newclass = 'warning';
            $tips_txt = '警告';
        }
        echo <<<html
        <!DOCTYPE html">
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>系统提示</title>
        <!--[if IE ]>
            <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico?20160321">
        <![endif]-->
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon/favicon2014.png?20160321"/>
        <style>
             *{margin:0;padding:0;}
            body{font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#313131;}
            a{color:#0088cc;text-decoration:none;}
            a:hover{color:#ff5500;}
            .systemTipPage{width: 660px;margin:100px auto 0; background-repeat: no-repeat;min-height: 200px}
            .systemTipPage.error {background-image: url(../images/version/error_tip@2x.png); background-size: 120px 109px; padding-left:145px;}
            .systemTipPage.warning {background-image: url(../images/version/warning@2x.png); background-size: 86px 120px; padding-left: 111px;}
            .systemTipPage.tips {background-image: url(../images/version/tips@2x.png); background-size: 85px 110px; padding-left: 110px;}
            .systemTipPage h3{font-size:24px;line-height:175%;margin-bottom:30px;}
            .systemTipPage p{font-size:18px;color:#313131;line-height:24px;}
            .systemTipPage p a{padding:0 4px;}
        </style>
        </head>
        <body>
        <div class="systemTipPage {$newclass}">
            <h3>{$tips_txt}提示</h3>
            <p>{$message_text}如果您的浏览器没有自动跳转，请点<a href="{$url}">这里</a></p>
        </div>
        <script type="text/javascript">
        setTimeout('window.location.replace("{$url}")', {$time});
        </script>
        </body>
        </html>
html;
        exit();
    }

    public static function log($msg, $file = '', $call_stack = true, $full_stack = true) {
        if ($msg instanceof Exception) {
            $msg = self::eToString($msg);
        }

        $m = "\n[" . date('Y-m-d H:i:s', time()) . "] "
            . (isset($_SERVER['SERVER_ADDR']) ? 'Host: ' . $_SERVER['SERVER_ADDR'] : '')
            . (($real_ip = self::getRealIp()) ? ' Client：' . $real_ip : '');
        $m .= ': ';
        if ($call_stack) {
            if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']) {
                $m .= "\n" . 'REQUEST_URL: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\n";
            }
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
                $m .= 'REFERER: http://' . $_SERVER['HTTP_REFERER'] . "\n";
            }
            $d = debug_backtrace();
            if (is_array($d)) {
                $i = 0;
                foreach ($d as $trace) {
                    $extra = ($i == 1) ? '  ***': '';
                    if (isset($trace['file'])) {
                        if ($full_stack || $i == 1) {
                            $m .= "\n" . $trace['file'] . ':' . $trace['line'] . $extra . "\n";
                        }
                    }
                    $i++;
                }
            }
        }
        $m .= $msg . "\n";

        $file = $file ? $file : '/tmp/tmp.log';
        $fp = @fopen($file, "a+");
        if ($fp) {
            fputs($fp, $m);
            fclose($fp);
        }
    }

    /**
     * @param Exception $e
     * @return string
     */
    public static function eToString($e) {
        return sprintf(
            "file:%s line:%s %s %s",
            $e->getFile(),
            $e->getLine(),
            $e->getMessage(),
            $e->getTraceAsString()
        );
    }

    public static function print_r($var) {
        echo '<pre>' . print_r($var, true) . '</pre>';
    }

    public static function var_export($var, $return = false) {
        if ($return) {
            return '<pre>' . var_export($var, true) . '</pre>';
        }
        echo '<pre>' . var_export($var, true) . '</pre>';
        return '';
    }

    public static function getFriendlyPubtime($loginLast) {
        $pubtime = ((is_numeric($loginLast)) ? $loginLast : strtotime($loginLast));
        $period = time() - $pubtime;
        if ($period < 0) {
            return "1秒前";
        } elseif ($period < 60) {
            return $period . "秒前";
        } elseif ($period < 3600) {
            return round($period / 60, 0) . "分钟前";
        } elseif ($period < 86400) {
            return round($period / 3600, 0) . "小时前";
            #        } elseif ($period < 86400 * 30) {
            #            return round($period / 86400, 0) . "天前";
        } else {
            return date('Y-m-d', $pubtime);
        }
    }

    public static function getPubtime($loginLast) {
        $pubtime = ((is_numeric($loginLast)) ? $loginLast : strtotime($loginLast));
        if ($pubtime > strtotime(date('Y-m-d 00:00:00'))) {
            $am = date('A', $pubtime);
            $str = date('h:i', $pubtime);
            if ($am == 'AM' && date('h', $pubtime) == 12) {
                $str = str_replace('12:', '00:', $str);
            }
            return ($am == 'AM' ? '上' : '下') . '午' . $str;
        } else if ($pubtime > strtotime(date('Y-m-d ', strtotime('-1 day')) . '00:00:00')) {
            return '昨天' . date('H:i', $pubtime);
        } else if (date('Y', $pubtime) != date('Y')) {
            return date('y-n-d', $pubtime);
        } else {
            return date('n-d', $pubtime);
        }
    }

    public static function outputExpireHeader($lifetime = 300) {
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + $lifetime) . " GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: max-age=$lifetime");
    }

    public static function outputHtml($str, $charset = 'utf-8') {
        self::outputExpireHeader(-86400);
        $html = <<<html
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$charset}" />
</head>
<body>
<div class="find_password">
    <ul>
        <li>{$str}</li>
    </ul>
</div>
</body>
html;
        echo '<!DOCTYPE html><html>' . sanitize($html) . '</html>';
    }

    /**
     * 输出出错信息后退出
     */
    public static function outputErrMessage($hint_msg) {
        $html = <<<html
${hint_msg}<br />点击<a href="/">这里</a>返回校内外首页。
html;
        Util::outputHTML($html);
        exit();
    }

    /**
     * 支持最大长度的将一个id添加到一个id_str
     */
    public static function addIdToIdStr($id_str, $id, $reverse = false, $delimiter = ',', $maxlen = 50000) {
        if ($reverse) {
            $id_str = $id_str ? $id_str . $delimiter . $id : $id;
            if (strlen($id_str) > $maxlen) {
                return substr($id_str, strpos($id_str, $delimiter) + 1);
            }
        } else {
            $id_str = $id_str ? $id . $delimiter . $id_str : $id;
            if (strlen($id_str) > $maxlen) {
                return substr($id_str, 0, strrpos($id_str, $delimiter));
            }
        }
        return $id_str;
    }

    public static function moveIdInIdstr($id_str, $id, $after = '', $delimiter = ',') {
        if (self::isExistInIdStr($id_str, $id, $delimiter)) {
            $new_id_str = self::removeIdFromIdStr($id_str, $id, $delimiter);
            if ($after) {
                if (self::isExistInIdStr($new_id_str, $after, $delimiter)) {
                    return str_replace($after, $after . $delimiter . $id, $new_id_str);
                }
            } else {
                //放到最前
                return $id . $delimiter . $new_id_str;
            }
        }

        return $id_str;
    }

    public static function forwardIdInIdstr($id_str, $id, $delimiter = ',') {
        if (Util::isExistInIdStr($id_str, $id, $delimiter)) {
            $id_str = Util::removeIdFromIdStr($id_str, $id, $delimiter);
        }
        return Util::addIdToIdStr($id_str, $id, $_reverse = false, $delimiter);
    }

    public static function removeIdFromIdStr($id_str, $id, $delimiter = ',') {
        $id_str = $delimiter . $id_str . $delimiter;
        return trim(str_replace("{$delimiter}{$id}{$delimiter}", $delimiter, $id_str), $delimiter);
    }

    public static function replaceIdFromIdStr($id_str, $oldId, $newId, $delimiter) {
        $id_str = $delimiter . $id_str . $delimiter;
        return trim(str_replace("{$delimiter}{$oldId}{$delimiter}", "{$delimiter}{$newId}{$delimiter}", $id_str), $delimiter);
    }

    public static function isExistInIdStr($id_str, $id, $delimiter = ',') {
        $id_str = $delimiter . $id_str . $delimiter;
        return strpos($id_str, "{$delimiter}{$id}{$delimiter}") !== false;
    }

    public static function getPosInIdStr($id_str, $id, $delimiter = ',') {
        $id_str = $delimiter . $id_str . $delimiter;
        return strpos($id_str, "{$delimiter}{$id}{$delimiter}");
    }

    private static function _getIdListByDirect($id_str, $id, $direct = 'forward', $num = 30, $delimiter = ',') {
        $pos = self::getPosInIdStr($id_str, $id);
        $id_list = array();
        if (false !== $pos) {
            if ($direct == 'forward') {
                $sub_str = substr($id_str, 0, $pos);
                $id_list = Util::explode($delimiter, $sub_str);
                return array_slice($id_list, -$num);
            } else {
                $sub_str = substr($id_str, $pos);
                $id_list = Util::explode($delimiter, $sub_str);
                //因为这里需要截取算上自己的num + 1个元素
                $num += 1;
            }
        } else {
            $id_list = explode($delimiter, $id_str);
        }
        return array_slice($id_list, 0, $num);
    }

    /*根据方向获取id列表*/
    private static function _getIdList($id_list, $id = 0, $old_count = 0, $new_count = 0) {
        if (!$old_count && !$new_count) {
            $new_count = 30;
        }
        $id_str = implode(',', $id_list);
        $result_id_list = array();
        if ($old_count) {
            $result_id_list = self::_getIdListByDirect($id_str, $id, $_direct = 'backward', $old_count);
        }
        if ($new_count) {
            $result_id_list = merge_id_list(self::_getIdListByDirect($id_str, $id, $_direct = 'forward', $new_count), $result_id_list);
        }
        return $result_id_list;
    }

    //获取显示用id list(各种图片相册)
    public static function getDispIdListAndIndex($id_list, $id, $old_count, $new_count, $start, $limit) {
        $index = 0;
        if ($id) {
            $flip_id_list = array_flip($id_list);
            if (isset($flip_id_list[$id])) {
                $index = $flip_id_list[$id];
            }
            $id_list = self::_getIdList($id_list, $id, $old_count, $new_count);
        } else {
            $id_list = array_slice($id_list, $start, $limit);
        }
        return array(
            'index' => $index,
            'id_list' => $id_list,
        );
    }

    public static function isUtf8($string) {
        return mb_detect_encoding($string, 'UTF-8', true);
        /*
        $pattern = '%(?:
        [\xC2-\xDF][\x80-\xBF]        # non-overlong 2-byte
        |\xE0[\xA0-\xBF][\x80-\xBF]               # excluding overlongs
        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}      # straight 3-byte
        |\xED[\x80-\x9F][\x80-\xBF]               # excluding surrogates
        |\xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
        |[\xF1-\xF3][\x80-\xBF]{3}                  # planes 4-15
        |\xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
        )+%xs';
        return preg_match($pattern, $string);
        */
    }

    /**
     * 判断一个字符串是否含有GBK编码的汉字
     */
    public static function isGbk($string) {
        //暂且认为不是UTF－8就是GBK
        return !self::isUtf8($string);
    }

    public static function badRequest($userdata = '') {
        $d = debug_backtrace();
        $m = '';
        foreach ($d as $trace) {
            $m .= $trace['file'] . ' : ' . $trace['line'] . "\n";
        }
        $m .= $_SERVER['REQUEST_URI'] . ':' . var_export($_REQUEST, true) . var_export($userdata, true);
        self::log($m, '/tmp/badrequest.log');
        self::msgRedirect('bad request', '/');
    }

    public static function systemError($userdata = '') {
        self::log($_SERVER['REQUEST_URI'] . ':' . var_export($_REQUEST, true) . var_export($userdata, true), '/tmp/system_error.log');
        self::msgRedirect('非常抱歉，系统故障.', '/');
    }

    #静默模式
    public static function systemErrorQuiet($userdata = '') {
        self::log($_SERVER['REQUEST_URI'] . ':' . var_export($_REQUEST, true) . var_export($userdata, true), '/tmp/system_error.log');
    }

    /**
     * 缩小图片
     */
    public static function makeThumb($src_file, $dst_file, $dst_width = 80, $dst_height = 60) {
        $handle = self::_getImageHandle($src_file);
        if (!$handle) {
            return false;
        }
        $im = $handle['handle'];
        $function = $handle['function'];

        $src_width = imagesx($im);
        $src_height = imagesy($im);

        if ($src_width <= $dst_width && $src_height <= $dst_height) {
            if ($dst_file != $src_file) {
                return copy($src_file, $dst_file);
            }
            return true;
        } else {
            $d_rate = round($dst_width / $dst_height, 4);
            $s_rate = round($src_width / $src_height, 4);
            if ($s_rate >= $d_rate) {  #太宽了
                $dst_height = round($src_height / ($src_width / $dst_width), 0);
            } else {
                $dst_width = round($src_width / ($src_height / $dst_height), 0);
            }
            $ni = imagecreatetruecolor($dst_width, $dst_height);
            imagecopyresampled($ni, $im, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
            return $function($ni, $dst_file);
        }
    }

    /**
     * 获取图片处理handle
     */
    private static function _getImageHandle($src_file) {
        $imginfo = @getimagesize($src_file);
        if (!is_array($imginfo)) {
            return array();
        }
        switch ($imginfo[2]) {
            case 1:
                $im = imagecreatefromgif($src_file);
                $function = 'imagegif';
                break;
            case 2:
                $im = imagecreatefromjpeg($src_file);
                $function = 'imagejpeg';
                break;
            case 3:
                $im = imagecreatefrompng($src_file);
                $function = 'imagepng';
                break;
            default:
                return array();
        }
        return array('handle' => $im, 'function' => $function);
    }

    public static function rotate($src_file, $dst_file, $degree) {
        $degree = $degree % 360;
        if ($degree < 0) {
            $degree += 360;
        }

        $handle = self::_getImageHandle($src_file);
        if (!$handle) {
            return false;
        }

        $im = $handle['handle'];
        $function = $handle['function'];

        // Rotate
        $rotate = imagerotate($im, (int)$degree, 0);
        // Output
        return $function($rotate, $dst_file);
    }

    public static function getImageSize($src_file) {
        $size = @getimagesize($src_file);
        $width = $height = 0;
        if ($size) {
            $width = $size[0];
            $height = $size[1];
        }
        return array('width' => $width, 'height' => $height);
    }

    /**
     * 截取指定位置指定大小图片
     * @param type string $src_img_url 原图云url地址
     * @param type array $corrdinate 指定位置坐标
     * @param type array $area 指定截取大小 长X宽
     * @param type array $scale 等比缩放比例尺
     */
    public static function subimg($src_img_url, array $coordinate, array $area, array $scale = array()) {
        if (!$image_info = getimagesize($src_img_url)) {
            return false;
        }

        $type_ext_dict = array(
            1 => 'gif',
            2 => 'jpeg',
            3 => 'png',
        );

        list($src_w, $src_h, $type) = $image_info;
        $imagecreatefrom = 'imagecreatefrom' . $type_ext_dict[$type];
        if (!($src_image = $imagecreatefrom($src_img_url))) {
            return false;
        }

        // 原图上开始截取的左上角坐标位置
        $src_x = $x = isset($coordinate['x']) ? $coordinate['x'] : 0;
        $src_y = $y = isset($coordinate['y']) ? $coordinate['y'] : 0;

        // 目标图片区域宽x高
        $dst_w = $w = isset($area['w']) ? $area['w'] : 0;
        $dst_h = $h = isset($area['h']) ? $area['h'] : 0;

        // 根据缩放比例，计算实际截取位置坐标和实际图片宽X高
        if ($scale && isset($scale['w'], $scale['h']) && $scale['w'] && $scale['h'] && ($src_w > IMAGE_PREVIEW_WIDTH || $src_h > IMAGE_PREVIEW_HEIGHT)) {
            if ($x) {
                $src_x = imagesx($src_image) * ($x / $scale['w']);
            }
            if ($y) {
                $src_y = imagesy($src_image) * ($y / $scale['h']);
            }
            $dst_w = $src_w * $w / $scale['w'];
            $dst_h = $src_h * $h / $scale['h'];
        }

        if (!$dst_w || !$dst_h || !($dst_image = imagecreatetruecolor($dst_w, $dst_h))) {
            return false;
        }

        //针对gif与png格式图片做特殊处理
        self::_processGifAndPng($type, $src_image, $dst_image);

        imagecopyresampled($dst_image, $src_image, $_dst_x = 0, $_dst_y = 0, $src_x, $src_y, $dst_w, $dst_h, $dst_w, $dst_h);

        $filename = '/tmp/' . md5(self::getUuid()) . '.' . $type_ext_dict[$type];
        $imagesave = 'image' . $type_ext_dict[$type];
        if ($imagesave($dst_image, $filename)) {
            if (is_resource($dst_image)) {
                imagedestroy($dst_image);
            }
            if (is_resource($src_image)) {
                imagedestroy($src_image);
            }
            return $filename;
        }

        return false;
    }

    /**
     * 裁切图片
     * 默认按110*110 剪切
     */
    public static function makeCutThumb($src_file, $dst_file, $cut_x, $cut_y, $cut_width = 110, $cut_height = 110) {
        $imginfo = getimagesize($src_file);
        if (!is_array($imginfo)) {
            return false;
        }

        $func = 'imagejpeg';
        switch ($imginfo[2]) {
            case 1:
                $im = imagecreatefromgif($src_file);
                $func = 'imagegif';
                break;
            case 2:
                $im = imagecreatefromjpeg($src_file);
                $func = 'imagejpeg';
                break;
            case 3:
                $im = imagecreatefrompng($src_file);
                imagesavealpha($im, true);
                $func = 'imagepng';
                break;
            default:
                return false;
        }
        if (!$im) {
            return false;
        }
        $cut_img = imagecreatetruecolor($cut_width, $cut_height);

        //针对gif与png格式图片做特殊处理
        self::_processGifAndPng($imginfo[2], $im, $cut_img);

        imagecopyresampled($cut_img, $im, 0, 0, $cut_x, $cut_y, $cut_width, $cut_height, $cut_width, $cut_height);
        return $func($cut_img, $dst_file);//将图片写到$dst_file
    }

    private static function _processGifAndPng($image_type, &$src_image, &$dst_image) {

        if (($image_type == IMAGETYPE_GIF) || ($image_type == IMAGETYPE_PNG)) {

            $trnprt_indx = imagecolortransparent($src_image);

            // If we have a specific transparent color
            if ($trnprt_indx >= 0) {

                // Get the original image's transparent color's RGB values
                $trnprt_color = imagecolorsforindex($src_image, $trnprt_indx);

                // Allocate the same color in the new image resource
                $trnprt_indx = imagecolorallocate($dst_image, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

                // Completely fill the background of the new image with allocated color.
                imagefill($dst_image, 0, 0, $trnprt_indx);

                // Set the background color for new image to transparent
                imagecolortransparent($dst_image, $trnprt_indx);
            } // Always make a transparent background color for PNGs that don't have one allocated already
            elseif ($image_type == IMAGETYPE_PNG) {

                // Turn off transparency blending (temporarily)
                imagealphablending($dst_image, false);

                // Create a new transparent color for image
                $color = imagecolorallocatealpha($dst_image, 0, 0, 0, 127);

                // Completely fill the background of the new image with allocated color.
                imagefill($dst_image, 0, 0, $color);

                // Restore transparency blending
                imagesavealpha($dst_image, true);
            }
        }
    }

    public static function getImageExtName($file_path) {
        $imginfo = getimagesize($file_path);
        if (!is_array($imginfo)) {
            return '';
        }
        $file_type = array(
            IMAGETYPE_GIF => '.gif',
            IMAGETYPE_JPEG => '.jpg',
            IMAGETYPE_PNG => '.png',
            IMAGETYPE_BMP => '.bmp',
        );
        $type = $imginfo[2];
        return ($type && isset($file_type[$type])) ? $file_type[$type] : '';
    }

    //判断是否为GIF动画
    public static function IsAnimatedGif($image_file) {
        $fp = fopen($image_file, 'rb');
        $image_head = fread($fp, 1024);
        fclose($fp);
        return strpos($image_head, chr(0x21) . chr(0xff) . chr(0x0b) . 'NETSCAPE2.0') === FALSE ? false : true;
    }

    public static function getDomainByEmail($email) {
        $i = stripos($email, '@');
        if (false !== $i) {
            return substr($email, $i + 1);
        }
        return '';
    }

    /**
     * @param $toemail string(20) "tann1013@hotmail.com"
     * @param $title string(21) "校内外邮箱注册"
     * @param $content string(49) "您的验证码为: 4861, 有效期为15分钟。"
     * @param string $alias_name string(9) "校内外"
     * @param bool $send_again true
     * @return bool
     */
    public static function sendmail($toemail, $title, $content, $alias_name = '校内外', $send_again = true) {
        require_once 'middle/EmailServiceMiddle.php';

        $toemail_prefix = substr($toemail, 0, strpos($toemail, '@'));
        $mail_info = array(
            'to_email'  =>$toemail,
            'to_profix' =>$toemail_prefix,

            'subject'   =>$title,
            'html'      =>$content,
        );

        try {
            $email_server = new EmailServiceMiddle($mail_info);
            $email_server->send();
            return true;
        } catch (Exception $e) {
            self::log('file:' . $e->getFile() . ' line:' . $e->getLine() . $e->getMessage() . $e->getTraceAsString(), '/tmp/system_error_mailgun.log');
            if ($send_again) {
                return self::sendmail($toemail, $title, $content, $alias_name = '校内外', $send_again = false);
            }
        }
        return false;
    }

    public static function prompt($title, $message, $url, $ishappy = true, $jump = false, $jump_seconds = 5) {
        require_once 'base/Resource.php';
        $tpl = Resource::getObj('ExtSmarty');
        $data = array(
            'title' => $title,
            'message' => $message,
            'url' => $url,
            'ishappy' => $ishappy,
            'jump' => $jump,
            'time' => $jump_seconds * 1000,
        );
        $tpl->assign('data', $data);
        $tpl->display('prompt.tpl');
        exit();
    }

    /**
     * 获取随机密码
     */
    public static function getRanPass($len = 10) {
        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789~!#$%^&*()_+|{}[]:"./\'`';
        $salt = '';
        $strlen = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $salt .= $str{mt_rand(0, $strlen - 1)};
        }
        return $salt;
    }

    /**
     * 随机变长密码的uuid
     */
    public static function getRanPassUuid() {
        $uuid = Util::getRanPass(mt_rand(10, 20)) . microtime(true);
        return md5($uuid);
    }

    /**
     * 获取基础 url (不带最后的文件名的那部分)
     */
    public static function getBaseUrl($url) {
        if (strpos($url, '?')) {
            $url = substr($url, 0, strpos($url, '?'));
        }
        return substr($url, -1) === '/' ? rtrim($url, '/') : substr($url, 0, strpos($url, strrchr($url, '/')));
    }

    public static function getHostByUrl($url) {
        $tmp = parse_url($url);
        return $tmp['host'];
    }

    /**
     * 获取一个页面的编码方式
     */
    public static function getCharsetFromHtml($html) {
        $pattern = '/<meta\s+http-equiv\s*=\s*[\'"]?content-type[\'"]?\s+content=[\'"]?text\/html;\s*charset\s*=\s*([\w\-\d]+)[\'"]?\s*\/?>/i';
        if (preg_match($pattern, $html, $_match)) {
            return $_match[1];
        }
        return 'gbk';
    }

    /**
     * 排序方法
     *
     * @param $keyAry oldkey=>newkey
     * @param $idAry oldkey=>id
     */
    public static function customSort($key_ary, $id_ary) {
        $new_id_ary = array();
        foreach ($key_ary as $old_key => $new_key) {
            if ($old_key == $new_key) {
                continue;
            }
            $old_key--;
            $new_key--;
            while (isset($new_id_ary[$new_key])) {
                $new_key++;
            }
            $new_id_ary[$new_key] = $id_ary[$old_key];
            unset($id_ary[$old_key]);
        }

        //不需排序
        if (!$new_id_ary) {
            return '-1';
        }

        $i = 0;
        foreach ($id_ary as $_id) {
            while (isset($new_id_ary[$i])) {
                $i++;
            }
            $new_id_ary[$i] = $_id;
        }
        ksort($new_id_ary);
        return join(',', $new_id_ary);
    }

    /**
     * 获取一个 webservice 的响应 xml
     */
    public static function getRemoteXml($url, $xmlstr, $opt = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlstr);
        foreach ($opt as $_k => $_v) {
            curl_setopt($ch, $_k, $_v);
        }
        return simplexml_load_string(curl_exec($ch));
    }

    /**
     * 任意十进制整数转换到任意进制(2-64)
     */
    public static function dec2any($num, $base = 64) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_~';
        $ret = '';
        if ($num > PHP_INT_MAX) {
            while (1) {
                $reminder = bcmod($num, $base);
                $ret = substr($pool, $reminder, 1) . $ret;

                $num = bcdiv($num, $base);
                if ($num < $base) {
                    if ($num) {
                        $ret = substr($pool, $num, 1) . $ret;
                    }
                    break;
                }
            }
        } else {
            while (1) {
                $reminder = $num % $base;
                $ret = substr($pool, $reminder, 1) . $ret;

                $num = floor($num / $base);
                if ($num < $base) {
                    if ($num) {
                        $ret = substr($pool, $num, 1) . $ret;
                    }
                    break;
                }
            }
        }
        return $ret;
    }

    public function any2dec($num, $base = 64) {

        $num = (string)$num;
        $ret = 0;

        $len = strlen($num);
        $i = 0;

        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_~';
        while ($len > 0) {
            $char = $num[$i]; //第几个字符
            $pos = strpos($pool, $char);
            $ret += $pos * pow((int)$base, $len - 1);
            $len--;
            $i++;
        }
        return $ret;
    }

    public static function dec262($in, $to_num = false) {
        $index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($index);
        if ($to_num) {
            // Digital number  <<--  alphabet letter code
            $in = strrev($in);
            $out = 0;
            $len = strlen($in) - 1;
            for ($t = 0; $t <= $len; $t++) {
                $bcpow = bcpow($base, $len - $t);
                $out = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
            }
            $out = sprintf('%F', $out);
            $out = substr($out, 0, strpos($out, '.'));
        } else {
            if ($in == 0) {
                return 'a';
            }

            $out = '';
            for ($t = floor(log($in, $base)); $t >= 0; $t--) {
                $bcp = bcpow($base, $t);
                $a = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in = $in - ($a * $bcp);
            }
            $out = strrev($out); // reverse
        }
        return $out;
    }

    /**
     * 使用除i,l,o以外的a-z字符以及2－9的数字
     *
     * @author HanChengfei
     * @date 20160428
     * @param int $in
     * @param bool $to_num
     * @return int|string
     */
    public static function dec231($in, $to_num = false) {
        $index = 'abcdefghjkmnpqrstuvwxyz23456789';
        $base = strlen($index);
        if ($to_num) {
            // Digital number  <<--  alphabet letter code
            $in = strrev($in);
            $out = 0;
            $len = strlen($in) - 1;
            for ($t = 0; $t <= $len; $t++) {
                $bcpow = bcpow($base, $len - $t);
                $out = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
            }
            $out = sprintf('%F', $out);
            $out = substr($out, 0, strpos($out, '.'));
        } else {
            if ($in == 0) {
                return 'a';
            }

            $out = '';
            for ($t = floor(log($in, $base)); $t >= 0; $t--) {
                $bcp = bcpow($base, $t);
                $a = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in = $in - ($a * $bcp);
            }
            $out = strrev($out); // reverse
        }
        return $out;
    }

    /**
     * @since 20100416
     * @author zhangyun@dianji.com
     */
    public static function get_k_m_g($byte_str, $precision = 2) {
        if (trim($byte_str) == '') {
            return '0 KB';
        }
        if (!ctype_digit($byte_str)) {
            return $byte_str;
        }
        //bytes = Math.floor(bytes / 100);
        if ($byte_str < 1024 * 1024) { // < 1 MB
            return round($byte_str / 1024, $precision) . ' KB';
        }
        if ($byte_str < 1024 * 1024 * 1024) {
            return round($byte_str / (1024 * 1024), $precision) . ' MB';
        }
        return round($byte_str / (1024 * 1024 * 1024), $precision) . ' GB';
    }

    /**
     * 判断验证码是否有效
     */
    public static function isValidIcode($str, $session_field = 'verifycode') {
        if (!isset($_SESSION[$session_field])) {
            return false;
        }
        $dict = array(
            'o' => '0',
            'i' => '1',
            'l' => '1',
        );
        $s_str = strtr(strtolower($str), $dict);
        $d_str = strtr(strtolower($_SESSION[$session_field]), $dict);
        return $s_str === $d_str;
    }

    /*
    *@desc 获取哈希后的静态地址通天塔
    */
    public static function getHashUrl($str = '') {
        $static = array(
            1 => 'http://1.xnwimg.com',
            2 => 'http://2.xnwimg.com',
            3 => 'http://3.xnwimg.com',
            4 => 'http://4.xnwimg.com',
            5 => 'http://1.xnwimg.com',
        );
        if ($str) {
            if (stripos(strtolower($str), 'http://') !== false) {
                return $str;
            }
            $hash = 0;
            $n = strlen($str);
            for ($i = 0; $i < $n; $i++) {
                if (($i & 1) == 0) {
                    $hash ^= (($hash << 7) ^ ord($str[$i]) ^ ($hash >> 3));
                } else {
                    $hash ^= (~(($hash << 11) ^ ord($str[$i]) ^ ($hash >> 5)));
                }
            }

            $staticIndex = abs($hash % 701819) % 5 + 1;
            return $static[$staticIndex] . $str;
            //return 'http://1.xnwimg.com' . $str;
        } else {
            $staticIndex = rand(1, 5);
            return $static[$staticIndex] . $str;
        }
    }

    public static function addSlashForSphinx($k) {
        $dict = array(
            '(' => '\(',
            ')' => '\)',
            '|' => '\|',
            '-' => '\-',
            '!' => '\!',
            '@' => '\@',
            '~' => '\~',
            '&' => '\&',
            '/' => '\/',
            '^' => '\^',
            '$' => '\$',
            '=' => '\=',
        );
        return strtr($k, $dict);
    }

    /*
    * 手机跳转页面
    **/
    public static function m_msgRedirect($msg, $url, $second = 3) {
        if (!$url) {
            $url = '/m/';
        }

        $url = get_safe_url($url);
        echo <<<html
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="{$second};URL={$url}" http-equiv="refresh">
</head>
<body>
{$msg} 如果没有跳转请<a href="{$url}">点击</a>这里
</body>
</html>
html;
        exit;
    }

    /**
     * 获取字符串宽度，半角字符1＝1，非半角角字符1＝2
     */
    public static function strwidth($str) {
        $charcount = mb_strlen($str, 'utf-8');
        $pattern = '/[[:print:][:space:]]/u';
        $halfcount = 0;
        if (preg_match_all($pattern, $str, $_match)) {
            $halfcount = sizeof($_match[0]);
        }
        return $halfcount + ($charcount - $halfcount) * 2;
    }

    /**
     * 首字母是否为数字
     */
    public static function is_numeric_begin($str) {
        return ctype_digit(substr($str, 0, 1));
    }

    public static function getUuid() {
        return uniqid(mt_rand(10000, 99999) . '-');
    }

    public static function get32Uuid() {
        return md5(self::getUuid());
    }

    public static function curl($method, $url, $param = array(), $pic_file = '', $pic_field_name = 'pic', $extra_header = array()) {
        $ch = curl_init();
        if (mb_strtoupper($method) === 'DELETE') {
            $query_string = '?';
            foreach ($param as $index => $value) {
                $query_string .= $index . '=' . rawurlencode($value) . '&';
            }
            if ($param) {
                $url .= rtrim($query_string, '&');
            }
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }
        if (mb_strtoupper($method) === 'GET') {
            $query_string = '?';
            foreach ($param as $index => $value) {
                $query_string .= $index . '=' . rawurlencode($value) . '&';
            }
            if ($param) {
                $url .= rtrim($query_string, '&');
            }
        }
        if (mb_strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            @curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            if ($pic_file) {
                $param[$pic_field_name] = $pic_file;
                @curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
            } else {
                $data = '';
                foreach ($param as $index => $value) {
                    $data .= $index . '=' . rawurlencode($value) . '&';
                }
                $data = rtrim($data, '&');
                @curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
        }

        //extra_header
        if (!$extra_header) {
            $extra_header = array('Expect:');
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $extra_header);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        if (false === $response) {
            Util::log(var_export(curl_error($ch), true), '/tmp/curlerror.log');
        }
        curl_close($ch);
        return $response;
    }

    /**
     * 32位的16进制的uuid
     */
    public static function getHexUuid() {
        $uuid = '';
        for ($i = 1; $i <= 32; $i++) {
            $uuid .= base_convert(mt_rand(1, 16), 10, 16);
        }
        return $uuid;
    }

    public static function download($filename) {
        $ua = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
        $encoded_filename = rawurlencode($filename);
        header('Content-Type: application/octet-stream');
        header("Accept-Ranges: bytes");
        if (preg_match('#MSIE#', $ua) || preg_match('#Trident|Edge/#i', $ua)) {
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        } else if (preg_match("/Firefox/", $ua)) {
            header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
        } else {
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        }

    }

    //生成二维码图片
    public static function qrCode($url, $addLogo = false) {
        require_once 'PHPQRCode/phpqrcode.php';
        QRcode::png($url, $outfile = false, $level = QR_ECLEVEL_Q, $size = 4, $margin = 1, $saveandprint=false, $addLogo);
    }

    public static function downloadExcel($filename, array $data = array()) {
        require_once "Encoding.php";
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Transfer-Encoding:binary");
        self::download($filename);
        $objPHPExcel = new PHPExcel();

        $index = 0;
        if ($data) {
            foreach ($data as $title => $row) {
                self::_createSheet($title, $row, $objPHPExcel, $index);
                $index++;
            }
        }

        $objPHPExcel->setActiveSheetIndex(0);
        ob_clean();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        //解决部分浏览器下载excel文件报502问题
        ob_flush();
    }

    private static function _createSheet($sheet_title, $rows, $objPHPExcel, $index = 0) {
        $sheet_title = (string)$sheet_title;
        if ($rows) {
            if ($index > 0) {
                $objPHPExcel->createSheet();
            }

            $objPHPExcel->setActiveSheetIndex($index)->setTitle($sheet_title);
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

            $activeSheet = $objPHPExcel->getActiveSheet();
            if ($sheet_title == '成绩统计') {
                $activeSheet->getColumnDimension('A')->setWidth(15);
            }

            $r = $i = 1;
            foreach ($rows as $_key => $row) {
                $char = 'A';
                $have_rows = false;
                if (is_array($row)) {
                    foreach ($row as $value) {
                        $value = \ForceUTF8\Encoding::toUTF8($value);

                        //$r=$i,保证一条数据中有多个字段是数组,使这些字段的数据分成一行显示
                        if ($have_rows) {
                            $r = $i;
                        }
                        //按excel中第一行数据进行设置,使数字列的数据右对齐
                        if ($r == 2 && is_numeric($value)) {
                            $activeSheet->getStyle($char)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        }

                        //如果一条数据中的某字段是一个数组,这个字段需要一行一行显示时,这么处理
                        if (is_array($value)) {
                            foreach ($value as $_value) {
                                $_value = \ForceUTF8\Encoding::toUTF8($_value);
                                $activeSheet->setCellValueExplicit("{$char}{$r}", $_value, PHPExcel_Cell_DataType::TYPE_STRING);
                                $r++;
                                $have_rows = true;
                            }
                            $r--;
                            $char++;
                        } else {
                            //正常导出EXCEL数据使用
                            $activeSheet->setCellValueExplicit("{$char}{$r}", $value, PHPExcel_Cell_DataType::TYPE_STRING);
                            $char++;
                        }
                    }
                    $r++;
                    $i = $r;
                }
            }
        }

        return $objPHPExcel;
    }

    public static function parseExcel($excel_file, $sheet_index=null) {
        return self::xls2Array($excel_file, $sheet_index);
    }

    /**
     * @param $excel_data = array(
     *      0 => array(
     *           'A' => '学号',
     *           'B' => '姓名',
     *           'C' => '手机号',
     *      ),
     *      1 => array(
     *           'A' => '001',
     *           'B' => '张三',
     *           'C' => '15899334443',
     *      ),
     *      ...
     * )
     *
     * @param $field_map = array(
     *       '学号'   => 'student_number',
     *       '姓名'   => 'name',
     *       '手机号' => 'mobile',
     * );
     *
     * @param int $limit 返回数量
     *
     * @return array(
     *      0 => array(
     *           'student_number' => '001',
     *           'name' => '张三',
     *           'mobile' => '15899334443',
     *      ),
     *      1 => array(
     *           'student_number' => '002',
     *           'name' => '李四',
     *           'mobile' => '13299334443',
     *      ),
     *      ...
     * )
     */
    public static function getExcelFieldData($excel_data, $field_map, $limit = 0) {
        if (!$excel_data) {
            return array();
        }

        $sheet_header = array_shift($excel_data);
        foreach ($sheet_header as &$_flip_name) {
            $_flip_name = mb_strtoupper($_flip_name);
        }

        $flip_sheet_header = array_flip($sheet_header);

        $valid_header = array();
        foreach ($field_map as $field => $title_name) {
            $title_list = Util::explode(',', $title_name);
            foreach ($title_list as $title) {
                if (isset($flip_sheet_header[$title])) {
                    $valid_header[$field] = $flip_sheet_header[$title];
                }
            }
        }

        $list = array();

        foreach ($excel_data as $excel_row) {
            $valid_row = array();
            foreach ($valid_header as $field_name => $sheet_column_name) {
                $valid_row[$field_name] = '';
                if (isset($excel_row[$sheet_column_name]) && ($excel_row[$sheet_column_name] || is_numeric($excel_row[$sheet_column_name]))) {
                    $valid_row[$field_name] = $excel_row[$sheet_column_name];
                }
            }

            if ($valid_row) {
                $list[] = $valid_row;
            }
        }

        if ($limit > 0) {
            return array_slice($list, 0, $limit);
        } else {
            return $list;
        }
    }

    public static function formatSheetHeader($sheet_header) {
        if (is_array($sheet_header)) {
            foreach ($sheet_header as &$header) {
                $header = preg_replace('/\s/', '', $header);
            }
        }
        return $sheet_header;
    }

    //命令行发日志
    public static function commandLineSendWeibo($qid, $content) {
        $gtalk_account = 'weizhong9@gmail.com';
        $code = md5('*' . $gtalk_account . '*');
        `curl --data-urlencode 'act=addWeibo' --data-urlencode "content={$content}" --data-urlencode "code={$code}" --data-urlencode "account=weizhong9@gmail.com" --data-urlencode "src=20" --data-urlencode "robot_type=gtalk" --data-urlencode "qid={$qid}" http://xnw.com/ajax.php`;
    }

    /**
     * 不会重复编码的聪明版 htmlspecialchars
     */
    public static function htmlspecialchars($str, $exclude_amp = false) {
        $quote_style = ENT_COMPAT | ENT_HTML401;
        $str = htmlspecialchars($str, $quote_style, $_charset = 'UTF-8', $_double_encode = false);
        if ($exclude_amp) {
            $str = str_replace(array('&amp;', '&quot;'), array('&', '"'), $str);
        }
        return $str;
    }

    public static function get_remote_fileinfo($uri) {
        // start output buffering
        ob_start();
        // initialize curl with given uri
        $ch = curl_init($uri);
        // make sure we get the header
        curl_setopt($ch, CURLOPT_HEADER, 1);
        // make it a http HEAD request
        curl_setopt($ch, CURLOPT_NOBODY, 1);

        curl_exec($ch);
        curl_close($ch);
        // get the output buffer
        $head = ob_get_contents();
        // clean the output buffer and return to previous
        // buffer settings
        ob_end_clean();

        // gets you the numeric value from the Content-Length
        // field in the http header

        $regex = '@Content-Length:\s(\d+)@';
        preg_match($regex, $head, $_matches);
        // if there was a Content-Length field, its value
        // will now be in $_matches[1]
        if (isset($_matches[1])) {
            $size = $_matches[1];
        } else {
            $size = 0;
        }
        $regex = '@Content-Type:\simage/(\w+)@';

        preg_match($regex, $head, $_matches);
        // if there was a Content-Length field, its value
        // will now be in $_matches[1]
        if (isset($_matches[1])) {
            $type = $_matches[1];
        } else {
            $type = '';
        }
        //$last=round($size/(1024*1024),3);
        //return $last.' MB';
        return array('size' => $size, 'type' => $type);
    }

    public static function getWeekList($year=0, $timestamp = false) {
        $week_list = [];
        $i = '01';
        $next_year_btime = strtotime(($year + 1) . '-01-01');

        while(($btime = strtotime("{$year}W{$i}"))) {
            if ($btime >= $next_year_btime) {
                break;
            }

            $i = (int)$i;
            $etime = strtotime("+7 day", $btime) - 1;

            if (!$timestamp) {
                $btime = date('Y-m-d H:i:s', $btime);
                $etime = date('Y-m-d H:i:s', $etime);
            }
            $week_list[$i] = [$btime, $etime];

            $i++;
            if($i < 10) {
                $i = '0' . $i;
            }
        }
        return $week_list;
    }

    //取指定年指定周的开始和结束时间戳
    public static function getWeekBeginEnd($year, $week = 1, $timestamp = true) {
        if (!$year) {
            $year = date('Y');
        }
        $week -= 1;
        //从年度第一周的周一算起第$week周
        $btime = strtotime("$week week", strtotime('last week +7 day', strtotime("$year-1-1")));
        $etime = strtotime("+7 day", $btime) - 1;
        if (!$timestamp) {
            $btime = date('Y-m-d H:i:s', $btime);
            $etime = date('Y-m-d H:i:s', $etime);
        }
        return array('begin' => $btime, 'end' => $etime);
    }

    //取某月第几周的开始和结束时间戳
    public static function getWeekBeginEndOfMonth($month, $number, $timestamp = true) {

        $month_period = self::getMonthBeginEnd($month);
        $month_time = strtotime($month);

        $mondays = array();
        $days = date('t', $month_time);
        for ($i = 1; $i <= $days; $i++) {
            $time = strtotime(date("Y-m-{$i}", $month_time));
            //取周一
            if (1 == date("w", $time)) {
                $mondays[] = $time;
            }
        }

        //把月的第一天压入数组并去重,索引连续
        array_unshift($mondays, $month_period['begin']);
        $mondays = array_values(array_unique($mondays));

        $begin = $end = '';
        foreach ($mondays as $i => $time) {
            if ($number == ($i + 1)) {
                $begin = $time;
                $end = isset($mondays[$i + 1]) ? ($mondays[$i + 1] - 1) : $month_period['end'];

                if (!$timestamp) {
                    $begin = date('Y-m-d H:i:s', $begin);
                    $end = date('Y-m-d H:i:s', $end);
                }
                break;
            }
        }

        return ($begin and $end) ? array(
            'begin' => $begin,
            'end' => $end
        ) : false;
    }

    /**
     * 获取月份里第N个星期五往前30天的时间范围
     * @param $month 月份（如：2015-09）
     * @param $week_number 月份里的第几个星期
     * @return array|bool
     */
    public static function getBeginEndOfFridayBefore($month, $week_number) {

        $month_weeks = self::getWeekListOfFridayBefore($month);

        foreach ($month_weeks as $i => $time_range) {
            if ($week_number == $i) {
                return $time_range;
            }
        }

        return false;
    }

    /**
     * @param $month 示例：2015-01,2015年01月
     * @param bool|false $with_last_week 若with_last_week为真，则返回结果包含跨月的那一周
     * @return array
     */
    public static function getWeekListOfFridayBefore($month, $with_last_week = false) {
        //获取一个月内所有星期五零点的时间戳
        $friday_list = self::_getWeekDayListOfMonth($month, $_week_day = 5);

        //以星期五0点为基准时间，初始化30天的时间段，作为统计分析时间段
        $month_weeks = array();
        foreach ($friday_list as $i => $time) {
            $month_weeks[$i + 1] = array(
                'begin' => $time - 29 * 24 * 3600,
                'end' => $time + 24 * 3600 - 1,
            );
        }

        if ($with_last_week) {  //如果包含指定月最后一个跨月周
            $time = $month_weeks[$i + 1];
            $last_week_day_num = date('t', $time['end']) - date('j', $time['end']);

            if ($last_week_day_num > 0) {
                $second = $last_week_day_num * 24 * 3600;
                $month_weeks[$i + 2] = array(
                    'begin' => $time['begin'] + $second,
                    'end' => $time['end'] + $second,
                );
            }
        }

        return $month_weeks;
    }

    //取某月的周列表
    public static function getWeekListOfMonth($month, $timestamp = true) {

        $mondays = self::_getWeekDayListOfMonth($month);

        $month_period = self::getMonthBeginEnd($month);

        //把月的第一天压入数组并去重,索引连续
        array_unshift($mondays, $month_period['begin']);
        $mondays = array_values(array_unique($mondays));

        $week_list = array();
        foreach ($mondays as $i => $time) {

            $begin = $time;
            $end = isset($mondays[$i + 1]) ? ($mondays[$i + 1] - 1) : $month_period['end'];
            if (!$timestamp) {
                $begin = date('Y-m-d H:i:s', $begin);
                $end = date('Y-m-d H:i:s', $end);
            }
            $week_list[$i + 1] = array($begin, $end);
        }

        return $week_list;
    }

    /**
     * 取时间戳所在xnw周(某年某月，第x周）的起止时间（xnw周是这样定义的：每周六00始到下周六00止，但不包括下周六00）
     * @param $timestamp 指定时间戳
     * @param bool $with_last_week 是否包含最后一个跨月周
     * @return string 返回的年月周信息，示例：2015-01,2 2015年01月第2周
     */
    public static function getWeekOfMonth($timestamp, $with_last_week = false) {
        $month = date("Y-m", $timestamp);
        $week_list = Util::getWeekListOfFridayBefore($month, $with_last_week);
        foreach ($week_list as $number => $time) {
            if ($timestamp >= $time['begin'] && $timestamp <= $time['end']) {
                return $month . "," . $number;
            }
        }
        return '';
    }

    /**
     * 获取一个月内所有星期为N的零点的时间戳
     * @param $month 月份
     * @param int $week_day 星期几
     * @return array
     */
    private static function _getWeekDayListOfMonth($month, $week_day = 1) {
        $month_period = self::getMonthBeginEnd($month);
        $month_first_day = $month_period['begin'];

        $week_day_list = array();
        $month_day_num = date('t', $month_first_day); //获取一个月的天数
        for ($i = 1; $i <= $month_day_num; $i++) {
            $time = strtotime(date("Y-m-{$i}", $month_first_day));
            //取星期的某一天
            if ($week_day == date("w", $time)) {
                $week_day_list[] = $time;
            }
        }

        return $week_day_list;
    }

    //某月的上一周
    public static function getLastWeekOfMonth($month_week) {
        $date = explode(",", $month_week);
        $month = $date[0];
        $week = (int)$date[1];

        if (($week - 1) < 1) {
            $last_month = self::getLastMonth($month);
            $week_list = self::getWeekListOfFridayBefore($last_month);

            return $last_month . "," . count($week_list);
        } else {
            return $month . "," . ($week - 1);
        }
    }

    public static function getMonthList($year = 0, $timestamp = false) {

        if (!$year) {
            $year = date('Y');
        }
        $year_start = $year . '-01-01';

        $month_list = array();
        for ($i = 0; $i < 12; $i++) {
            $btime = strtotime("$year_start $i month");
            $etime = strtotime("$year_start" . ($i + 1) . " month") - 1;
            if (!$timestamp) {
                $btime = date('Y-m-d H:i:s', $btime);
                $etime = date('Y-m-d H:i:s', $etime);
            }
            $month_list[$i + 1] = array($btime, $etime);
        }
        return $month_list;
    }

    //得到一个月(Y-m 格式)的开始和结束时间戳
    public static function getMonthBeginEnd($month = 0) {//return $date;
        if (!$month) {
            $month_begin = date('Y-m-01');
        } else {
            $month_begin = date('Y-m-01', strtotime($month));
        }
        $start = strtotime($month_begin);
        $end = strtotime(self::getNextMonth($month_begin));
        return array('begin' => $start, 'end' => $end - 1);
    }

    public static function getLastMonth($date) {
        return date('Y-m', strtotime(date('Y-m-01', strtotime($date))) - 1);
    }

    public static function getNextMonth($date) {
        return date('Y-m', strtotime('+1 month', strtotime($date)));
    }

    public static function getWeekDay($time) {
        if (is_numeric($time)) {
            $weekday = array('星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六');
            return $weekday[date('w', $time)];
        }
        return '';
    }

    /**
     * Crypt/decrypt strings with RC4 stream cypher algorithm.
     *
     * @param string $key Key
     * @param string $data Encripted/pure data
     * @see   http://pt.wikipedia.org/wiki/RC4
     * @return string
     */
    public static function rc4($key, $data) {
        // Store the vectors "S" has calculated
        static $SC;
        // Function to swaps values of the vector "S"
        $swap = create_function('&$v1, &$v2', '
    $v1 = $v1 ^ $v2;
    $v2 = $v1 ^ $v2;
    $v1 = $v1 ^ $v2;
');
        $ikey = crc32($key);
        if (!isset($SC[$ikey])) {
            // Make the vector "S", basead in the key
            $S = range(0, 255);
            $j = 0;
            $n = strlen($key);
            for ($i = 0; $i < 255; $i++) {
                $char = ord($key{$i % $n});
                $j = ($j + $S[$i] + $char) % 256;
                $swap($S[$i], $S[$j]);
            }
            $SC[$ikey] = $S;
        } else {
            $S = $SC[$ikey];
        }
        // Crypt/decrypt the data
        $n = strlen($data);
        $data = str_split($data, 1);
        $i = $j = 0;
        for ($m = 0; $m < $n; $m++) {
            $i = ($i + 1) % 256;
            $j = ($j + $S[$i]) % 256;
            $swap($S[$i], $S[$j]);
            $char = ord($data[$m]);
            $char = $S[($S[$i] + $S[$j]) % 256] ^ $char;
            $data[$m] = chr($char);
        }
        return implode('', $data);
    }

    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::                                                                         :*/
    /*::  This routine calculates the distance between two points (given the     :*/
    /*::  latitude/longitude of those points). It is being used to calculate     :*/
    /*::  the distance between two locations using GeoDataSource(TM) Products    :*/
    /*::                                                                         :*/
    /*::  Definitions:                                                           :*/
    /*::    South latitudes are negative, east longitudes are positive           :*/
    /*::                                                                         :*/
    /*::  Passed to function:                                                    :*/
    /*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
    /*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
    /*::    unit = the unit you desire for results                               :*/
    /*::           where: 'M' is statute miles                                   :*/
    /*::                  'K' is kilometers (default)                            :*/
    /*::                  'N' is nautical miles                                  :*/
    /*::  Worldwide cities and other features databases with latitude longitude  :*/
    /*::  are available at http://www.geodatasource.com                          :*/
    /*::                                                                         :*/
    /*::  For enquiries, please contact sales@geodatasource.com                  :*/
    /*::                                                                         :*/
    /*::  Official Web site: http://www.geodatasource.com                        :*/
    /*::                                                                         :*/
    /*::         GeoDataSource.com (C) All Rights Reserved 2013                  :*/
    /*::                                                                         :*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = mb_strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public static function getDistance($lat1, $lng1, $lat2, $lng2) {
        $R = 6378137;

        //将角度转为狐度
        $radLat1 = deg2rad($lat1);
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);

        //结果
        $s = acos(cos($radLat1) * cos($radLat2) * cos($radLng1 - $radLng2) + sin($radLat1) * sin($radLat2)) * $R;

        //精度
        $s = round($s * 10000) / 10000;
        return round($s);
    }

    //注意PHP5.4及以上版才可以用
    public static function json_encode($val) {
        return json_encode($val, JSON_UNESCAPED_UNICODE);
    }

    //把Excel电子表转化为PHP数组
    public static function xls2Array($excel_file, $sheet_index = null) {
        try {
            $php_excel = PHPExcel_IOFactory::load($excel_file);

            if ($sheet_index === null) {
                $excel_sheet = $php_excel->getActiveSheet();
            } else {
                $excel_sheet = $php_excel->getSheet($sheet_index);
            }

            $result = array();
            foreach ($excel_sheet->getRowIterator() as $row_number => $sheet_row) {
                $data_row = array();
                foreach ($sheet_row->getCellIterator() as $cell) {
                    $data_row[$cell->getColumn()] = trim($cell->getValue());
                }
                if (join('', $data_row)) {
                    $result[$row_number] = $data_row;
                }
            }
        }  catch (Exception $e) {

            $msg = $e->getMessage();
            if (self::_isSpecialException($msg)) {
                $msg = self::_getSpecialExceptionFiendlyMsg($msg);
            }

            throw new BusinessException($msg, \base\ResponseHelper::SERVER_ERROR_EXCEL);
        }

        return $result;
    }

    public static function _getSpecialException() {
        $help_tel = '若您方便, 请即刻联系客服: ' . CUSTOM_SERVICE_TEL;
        return array(
            md5('Merge must be set on a range of cells.') => '请认真检查您上传的Excel文件格式是否符合要求！'. $help_tel
        );
    }

    public static function _isSpecialException($error_msg) {
        $error_msg = md5($error_msg);
        $exception_msg_array = self::_getSpecialException();
        return isset($exception_msg_array[$error_msg]);
    }

    public static function _getSpecialExceptionFiendlyMsg ($error_msg) {
        $error_msg = md5($error_msg);
        $exception_msg_array = self::_getSpecialException();
        if (isset($exception_msg_array[$error_msg]) && $exception_msg_array[$error_msg]) {
            return $exception_msg_array[$error_msg];
        }
        return $error_msg;
    }

    //获取Excel表头数据,若某一行数据与识别文本一致，就认为这一行是表头
    public static function get_sheet_header($sheet, $flag_text = '学校代码') {
        foreach ($sheet as $row) {
            if (($r = self::is_sheet_header($row, $flag_text))) {
                return $r;
            }
        }
        return false;
    }

    public static function is_sheet_header($row, $flag_text) {
        foreach ($row as $_k => $_v) {
            if (trim($_v) == $flag_text) {
                return $row;
            }
        }
        return false;
    }

    public static function getRandomAccountStr($length = 6) {
        // 除i,l,o,I,O,0,1外的字符
        $str = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $output = '';
        $strlen = strlen($str);
        for ($i = 0; $i < $length; $i++) {
            $output .= $str[mt_rand(0, $strlen - 1)];
        }
        return $output;
    }

    /*快速检查一个id是否位于一个由id组成的数组内*/
    public static function idInArray($id, $id_list) {
        $id_list = array_flip($id_list);
        return isset($id_list[$id]);
    }

    public static function merge_array_unique($arr1, $arr2) {
        return array_keys(array_flip($arr1) + array_flip($arr2));
    }

    /*此方法要求$need本身是一个字符串，且$haystack 数组中元素的值必须为字符串*/
    public static function in_array($need, $haystack) {
        $haystack = array_flip($haystack);
        return isset($haystack[$need]);
    }

    /*
    * 标准数组变关联数组
    */
    public static function regular2assoc($regular, $key_field = 'id') {
        $new_array = array();
        foreach ($regular as $r) {
            if (isset($r[$key_field])) {
                $new_array[$r[$key_field]] = $r;
            }
        }
        return $new_array;
    }

    public static function removeEmoji($text) {
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);

        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);

        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);

        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);

        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);

        return $clean_text;
    }

    //将指定id移到id数组的最前面，如果$id_list中不存在$id则加在头部
    public static function array_makeIdFirst(&$id_list, $id) {
        return $id_list = array_keys(array($id => '') + array_flip($id_list));
    }

    //id字符串变数组
    public static function idstr2array($id_str) {
        return $id_str ? Util::explode(',', @(string)$id_str) : array();
    }

    /**
     * 数组去重 不区分大小写版
     * @param array $array
     * @return array
     */
    public static function array_iunique(array $array) {
        $unique_array = $iunique_array = array();
        foreach ($array as $value) {
            $istr = mb_strtolower($value, $_encoding = 'utf8');
            if (!isset($iunique_array[$istr])) {
                $iunique_array[$value] = '';
                $unique_array[] = $value;
            }
        }

        return $unique_array;
    }

    /**
     * 数组去重 高效版
     * 数组的值只能是integer或者String
     *
     * @param array $array
     * @return array
     */
    public static function array_unique(array $array) {
        return array_keys(array_flip($array));
    }

    /**
     * 删除一个数组中的某个值
     *
     * @param $value
     * @param array $array
     * @return array
     */
    public static function array_unset($value, array $array) {
        if (self::in_array($value, $array)) {
            foreach ($array as $key => $val) {
                if ($val == $value) {
                    unset($array[$key]);
                }
            }

            $array = array_values($array);
        }

        return $array;
    }

    public static function arrayStrToUpper($value, $encoding = 'utf8') {
        return is_array($value) ? array_map(array(
            'Util',
            'arrayStrToUpper'
        ), $value) : mb_strtoupper($value, $encoding);
    }

    public static function arrayStrToLower($value, $encoding = 'utf8') {
        return is_array($value) ? array_map(array(
            'Util',
            'arrayStrToLower'
        ), $value) : mb_strtolower($value, $encoding);
    }

    public static function getValidCloudId($string) {
        if (preg_match('/' . CLOUDID_PATTERN . '/', $string, $_matched)) {
            return $_matched[0];
        }
        return '';
    }

    public static function date_diff($date, $date1, $diff_format = '%a') {
        return date_diff(date_create($date), date_create($date1))->format($diff_format);
    }

    //$id_list 要求必须是从大到小
    public static function getUnreadTotal($id_list, $last_id, $limit = 1024) {
        $unread = 0;
        foreach ($id_list as $id) {
            if ($id <= $last_id || $unread == $limit) {
                break;
            }
            $unread++;
        }
        return $unread;
    }

    public static function id_list_intersect($a, $b) {
        $sizea = sizeof($a);
        $sizeb = sizeof($b);
        if ($sizea < $sizeb) {
            return self::_id_list_intersect($a, $b);
        } else {
            return self::_id_list_intersect($b, $a);
        }
    }

    private static function _id_list_intersect($a, $b) {
        $a = array_flip($a);
        $b = array_flip($b);
        return array_keys(array_intersect_key($a, $b));
    }

    public static function probablyChinaMobile($mobile) {
        $not_china_mobile = array(
            //中国电信
            '133' => '',
            '153' => '',
            '180' => '',
            '181' => '',
            '189' => '',
            '177' => '',
            //中国联通
            '130' => '',
            '131' => '',
            '132' => '',
            '155' => '',
            '156' => '',
            '185' => '',
            '186' => '',
        );

        $num = substr($mobile, 0, 3);
        return !isset($not_china_mobile[$num]);
    }

    /**
     * 记录和统计时间（微秒）和内存使用情况
     * 使用方法:
     * <code>
     * G('begin'); // 记录开始标记位
     * // ... 区间运行代码
     * G('end'); // 记录结束标签位
     * echo G('begin','end',6); // 统计区间运行时间 精确到小数后6位
     * echo G('begin','end','m'); // 统计区间内存使用情况
     * 如果end标记位没有定义，则会自动以当前作为标记位
     * </code>
     * @param string $start 开始标签
     * @param string $end 结束标签
     * @param integer|string $dec 小数位或者m
     * @param boolean $mem_limt 统计内存使用
     * @return mixed
     */
    public static function G($start, $end = '', $dec = 4, $mem_limit = true) {
        static $_info = array();
        static $_mem = array();
        if (is_float($end)) { // 记录时间
            $_info[$start] = $end;
        } elseif (!empty($end)) { // 统计时间和内存使用
            if (!isset($_info[$end])) {
                $_info[$end] = microtime(true);
            }
            if ($mem_limit && $dec == 'm') {
                if (!isset($_mem[$end])) {
                    $_mem[$end] = memory_get_usage();
                }
                return number_format(($_mem[$end] - $_mem[$start]) / 1024);
            } else {
                return number_format(($_info[$end] - $_info[$start]), $dec);
            }
        } else { // 记录时间和内存使用
            $_info[$start] = microtime(true);
            if ($mem_limit) {
                $_mem[$start] = memory_get_usage();
            }
        }
        return null;
    }

    public static function array_column($array, $column_key) {
        if (function_exists('array_column')) {
            $array_column = array_column($array, $column_key, $column_key);
        } else {
            $array_column = array();
            foreach ($array as $arr) {
                $array_column[$arr[$column_key]] = '';
            }
        }

        // 确保不返回空值
        foreach ($array_column as $key => $_null) {
            if ($key === '') {
                unset($array_column[$key]);
            }
        }
        return array_keys($array_column);
    }

    public static function array_repeat_column($array, $column_key, $index_kdy = null) {
        if (function_exists('array_column')) {
            $array_column = array_column($array, $column_key, $index_kdy);
        } else {
            $array_column = array();
            foreach ($array as $arr) {
                $array_column[$arr[$column_key]] = '';
            }
        }

        // 确保不返回空值
        foreach ($array_column as $key => $_null) {
            if ($key === '') {
                unset($array_column[$key]);
            }
        }
        return $array_column;
    }

    /*
     *  @param string$filename 文件的名字
     *  @param array
     * $column_list = array(
            'rxnf' => '入学年份',
            'grade' => '年级',
            'class' => '班级(班)',
            'headteacher' => '班主任姓名',
            'mobile' => '班主任手机号',
        );
     */
    public static function export_excel($filename, $column_list) {
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Transfer-Encoding:binary");
        Util::download($filename);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('firstsheet');
        $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
        //设置过显示顺序则excel导入按照显示顺序给出列明
        $new_temp_column = 'A';
        foreach ($column_list as $value) {
            $objPHPExcel->getActiveSheet()->setCellValue($new_temp_column . '1', $value);
            ++$new_temp_column;
        }
        return $objPHPExcel;
    }

    public static function parse_str($string, &$result) {
        if ($string === '') {
            return false;
        }
        $result = array();
        // find the pairs "name=value"
        $pairs = explode('&', $string);
        $params = array();
        foreach ($pairs as $pair) {
            // use the original parse_str() on each element
            parse_str($pair, $params);
            $k = key($params);
            if (!isset($result[$k])) {
                $result += $params;
            } else {
                $result[$k] = self::array_merge_recursive_distinct($result[$k], $params[$k]);
            }
        }
        return true;
    }

    // better recursive array merge function listed on the array_merge_recursive PHP page in the comments
    public static function array_merge_recursive_distinct(array $array1, array $array2) {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = self::array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }
        return $merged;
    }

    //获取当前页面的URL及其的参数
    public static function get_request_uri() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            if (isset($_SERVER['argv'])) {
                $uri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['argv'][0];
            } else {
                $uri = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
            }
        }
        return $uri;
    }

    public static function parse_time($time_str, $time_format = 'H:i') {
        $date_info = date_parse_from_format($time_format, $time_str);
        if ($date_info['warning_count'] || $date_info['error_count']) {
            return array();
        }
        $date_value = array(
            'year' => false,
            'month' => false,
            'day' => false,
            'hour' => false,
            'minute' => false,
            'second' => false,
            'fraction' => false,
        );

        $date_info = array_intersect_key($date_info, $date_value);
        $date_info['unixtime'] = strtotime($time_str);

        foreach ($date_info as $date => $value) {
            if (false === $value) {
                unset($date_info[$date]);
            }
        }

        return $date_info;
    }

    public static function iconv_set_encoding($encoding = 'UTF-8') {
        if (PHP_VERSION_ID < 50600) {
            iconv_set_encoding('internal_encoding', $encoding);
        } else {
            ini_set('default_charset', 'UTF-8');
        }
    }

    /**
     * 取汉字的第一个字的首字母
     * @param type $str
     * @return string|null
     */
    public static function getFirstChar($str){
        if (empty($str)) {
            return '';
        }

        $fir = $fchar = ord($str[0]);
        if ($fchar >= ord('A') && $fchar <= ord('z')) {
            return strtoupper($str[0]);
        }

        $s1 = @iconv('UTF-8', 'gb2312', $str);
        $s2 = @iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s[0]) * 256 + ord($s[1]) - 65536;

        if (is_numeric($str)) {
            return $str;
        }
        if (($asc >= -20319 && $asc <= -20284) || $fir == 'A') {
            return 'A';
        }
        if (($asc >= -20283 && $asc <= -19776) || $fir == 'B') {
            return 'B';
        }
        if (($asc >= -19775 && $asc <= -19219) || $fir == 'C') {
            return 'C';
        }
        if (($asc >= -19218 && $asc <= -18711) || $fir == 'D') {
            return 'D';
        }
        if (($asc >= -18710 && $asc <= -18527) || $fir == 'E') {
            return 'E';
        }
        if (($asc >= -18526 && $asc <= -18240) || $fir == 'F') {
            return 'F';
        }
        if (($asc >= -18239 && $asc <= -17923) || $fir == 'G') {
            return 'G';
        }
        if (($asc >= -17922 && $asc <= -17418) || $fir == 'H') {
            return 'H';
        }
        if (($asc >= -17417 && $asc <= -16475) || $fir == 'J') {
            return 'J';
        }
        if (($asc >= -16474 && $asc <= -16213) || $fir == 'K') {
            return 'K';
        }
        if (($asc >= -16212 && $asc <= -15641) || $fir == 'L') {
            return 'L';
        }
        if (($asc >= -15640 && $asc <= -15166) || $fir == 'M') {
            return 'M';
        }
        if (($asc >= -15165 && $asc <= -14923) || $fir == 'N') {
            return 'N';
        }
        if (($asc >= -14922 && $asc <= -14915) || $fir == 'O') {
            return 'O';
        }
        if (($asc >= -14914 && $asc <= -14631) || $fir == 'P') {
            return 'P';
        }
        if (($asc >= -14630 && $asc <= -14150) || $fir == 'Q') {
            return 'Q';
        }
        if (($asc >= -14149 && $asc <= -14091) || $fir == 'R') {
            return 'R';
        }
        if (($asc >= -14090 && $asc <= -13319) || $fir == 'S') {
            return 'S';
        }
        if (($asc >= -13318 && $asc <= -12839) || $fir == 'T') {
            return 'T';
        }
        if (($asc >= -12838 && $asc <= -12557) || $fir == 'W') {
            return 'W';
        }
        if (($asc >= -12556 && $asc <= -11848) || $fir == 'X') {
            return 'X';
        }
        if (($asc >= -11847 && $asc <= -11056) || $fir == 'Y') {
            return 'Y';
        }
        if (($asc >= -11055 && $asc <= -10247) || $fir == 'Z') {
            return 'Z';
        }
        return '';
    }

    /**
     * 二维数组，按字段排序，遇到中文会按拼音首字母排序
     * @param array $array
     * @param $column
     * @return array 去除key的二维数组
     */
    public static function sortByArrColumn(array $array, $column) {

        $new_array = [];
        $temp = [];
        $index = 1;
        foreach ($array as $item) {
            $column_value = $item[$column];
            if (is_numeric($column_value)) {
                $temp[] = $item;
            } else {
                $snameFirstChar = self::getFirstChar($column_value); //取第一个汉字的首字母
                if (isset($new_array[$snameFirstChar])) {
                    $new_array[$snameFirstChar . $index] = $item;//以这个首字母作为key
                    $index ++;
                } else {
                    $new_array[$snameFirstChar] = $item;//以这个首字母作为key
                }
            }
        }
        ksort($new_array, SORT_NATURAL); //对数据进行ksort排序，以key的值升序排序

        return array_merge(array_values($new_array), $temp);
    }

    public static function splitFakeIdList($id_list, &$fake_id_list = []) {
        $fake_id_list = $real_id_list = [];

        if (!$id_list) {
            return $real_id_list;
        }

        foreach ($id_list as $id) {
            // 真正的id都是整数
            if ($id && is_numeric($id) && ($real_id = (int)$id) == $id) {
                $real_id_list[] = $real_id;
            } else {
                // 程序传过来的id list中很多都带有一个0.这里不做fake处理，只是简单去掉
                if ($id == 0) {
                    continue;
                }
                $fake_id_list[] = $id;
            }
        }

        // 有虚假id很可能是sql注入,记下日志,排查来源
        if ($fake_id_list) {
            $trace = debug_backtrace();
            self::log(
                sprintf(
                    '%s::%s 可能遇到sql注入: ip=%s, $id_list=%s, $fake_id_list=%s',
                    @$trace[1]['class'],
                    @$trace[1]['function'],
                    self::getRealIp(),
                    var_export($id_list, true),
                    var_export($fake_id_list, true)
                ),
                SQL_INJECT_LOG
            );
        }

        return $real_id_list;
    }

    /**
     * 计算两个坐标之间的距离(米)
     * @param float $fP1Lat 起点(纬度)
     * @param float $fP1Lon 起点(经度)
     * @param float $fP2Lat 终点(纬度)
     * @param float $fP2Lon 终点(经度)
     * @return int
     */
    public static function distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon){
        $fEARTH_RADIUS = 6378137;
        //角度换算成弧度
        $fRadLon1 = deg2rad($fP1Lon);
        $fRadLon2 = deg2rad($fP2Lon);
        $fRadLat1 = deg2rad($fP1Lat);
        $fRadLat2 = deg2rad($fP2Lat);
        //计算经纬度的差值
        $fD1 = abs($fRadLat1 - $fRadLat2);
        $fD2 = abs($fRadLon1 - $fRadLon2);
        //距离计算
        $fP = pow(sin($fD1/2), 2) +
            cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2/2), 2);
        return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
    }



    public static function week_dec2caps($dec, $prefix='星期') {
        $dec2caps = [
            0 => '日',
            1 => '一',
            2 => '二',
            3 => '三',
            4 => '四',
            5 => '五',
            6 => '六',
        ];

        return isset($dec2caps[$dec]) ? $prefix . $dec2caps[$dec] : false;
    }

    public static function week_caps2dec($caps, $prefix='星期') {
        $caps = str_replace($prefix, '', $caps);

        $caps2dec = [
            '日' => 0,
            '一' => 1,
            '二' => 2,
            '三' => 3,
            '四' => 4,
            '五' => 5,
            '六' => 6,
        ];

        return isset($caps2dec[$caps]) ? $caps2dec[$caps] : false;
    }


    /**
     * 找到今天的第一秒
     * @param $time
     * @return false|int
     */
    public static function getFirstSecondTimestamp($time) {
        return strtotime(date('Y-m-d', $time));
    }

    /**
     * 找到今天的最后一秒
     * @param $time
     * @return false|int
     */
    public static function getLastSecondTimestamp($time) {
        return strtotime(date('Y-m-d', $time)) + 86400 - 1;
    }

    /**
     * 取上周的开始日期、结束日期（周日算一周的最后一天）
     */
    public static function getLastWeekDateRange() {
        $week_date_num = date('N');

        $end_date = date(
            'Y-m-d',
            strtotime("-{$week_date_num} days")
        );

        $begin_date = date(
            'Y-m-d',
            strtotime('-6 days', strtotime($end_date))
        );

        return array(
            $begin_date,
            $end_date
        );
    }
}

