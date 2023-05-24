<?php
class security {
    private $url, $conn, $limit=5;
    private $post = array(), $get = array(), $lurl=array();
    
    
    private function connect() {
        $this->conn = new mysqli("sql109.epizy.com", "epiz_34205428", "nm71NfTZps88VUO", "epiz_34205428_march");
        
    }
    private function alert() {
        header("Location: http://wncerrorpage.rf.gd");
        
    }
    private function validate($x) {
        $a = array("../", "<", ">", "+", "union");
        foreach ($a as $b) {
            if (substr_count($x, urlencode($b))>0) {
                $this->alert();
                break;    
            }
        }
    }

    private function sanitize($x) {
       $r = filter_var($x, FILTER_SANITIZE_STRING);
       return $r;
    }
    
    private function filter1() {
        $this->validate($_SERVER["REQUEST_URI"]);
        
        $this->url = $this->sanitize($_SERVER["REQUEST_URI"]);
        
        foreach ($_POST as $k => $v) {
            $this->validate($v);
            $r = $this->sanitize($v);
            $this->post[$k] = $r;
        }
        foreach ($_GET as $k => $v) {
            $this->validate($v);
            $r = $this->sanitize($v);
            $this->get[$k] = $r;
        }
    }
    
    private function filter0() {
        
        
        $a = $_SERVER["HTTP_X_REAL_IP"];
        $b = $_SERVER["HTTP_HOST"];
        $c = $this->sanitize($_SERVER["REQUEST_URI"]);
        $e = $_SERVER["HTTP_USER_AGENT"];
        $d = time();
        $d1 = time()-1;
        
        
        $f = $this->conn;
        $df = "select `time` from `log` where `time` >=$d1 and `ip`='$a'";
        $do = $f->query($df);
        
        
        if ($do->num_rows > $this->limit) {
            $this->alert();
            
         
        }
        
        $f->query("INSERT INTO `log`(`time`, `ip`, `host`, `req`, `agent`) VALUES ('$d','$a','$b','$c', '$e')");
    }
    private function redirecting() {
      
        $l = explode("?", $_SERVER["REQUEST_URI"])[0];
        
      
        if (isset($this->lurl[$l])) {
            $j = $this->lurl[$l];
           
            header("Location: $j");
        }
    }
    public function redirect($k, $v) {
        $this->lurl[$k] = $v;
    }
    public function geturl() {
        return $this->url;
    }
    public function getpost() {
        return $this->post;
    }
    public function getget() {
        return $this->get;
    }
    public function limit($p) {
        $this->limit = $p;
    }
    public function clearpost($p) {
        unset($this->post[$p]);
    }
    public function reload() {
        header("Location: $this->url");
    }
    public function run() {
        $this->redirecting();
        $this->connect();
        $this->filter0();
        $this->filter1();
    }
}
?>