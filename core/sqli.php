<?php

class sqlConnector {
    public $con;
    public $pager;
    public $db_host;
    public $db_user;
    public $db_pass;
    public $db_name;
    public $connected = 0;
    public $debug = "off";
    public $closeConnection = false; //nie zamyka polaczenia po wykonaniu Query
    
    public $statement;
    
    public function __construct($params=null){
        global $variables; $this->variables =& $variables;
        if ($params!=null){
            $this->db_host = $params['db_host'];
            $this->db_user = $params['db_user'];
            $this->db_pass = $params['db_pass'];
            $this->db_name = $params['db_name'];
        } else {
            $this->db_host = $this->variables->db_host;
            $this->db_user = $this->variables->db_user;
            $this->db_pass = $this->variables->db_pass;
            $this->db_name = $this->variables->db_name;
        }
        
        //$this->debug_rlo = 1;
        //$this->debug_pagi = 1;
        //$this->debug_query = 1;

        $this->debug = $this->variables->debug;
        
        $this->statement['bad_data'] = 'Źle podany login lub hasło do MySQL ';
        $this->statement['bad_base'] = 'Źle podana nazwa bazy ';
    }
    
    private function open(){    
        
        $this->con = new mysqli('localhost',$this->db_user,$this->db_pass,$this->db_name);

        if($this->con->connect_error) 
            die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());

        
        
        
       // $this->con = mysql_connect($this->db_host,$this->db_user,$this->db_pass) or die($this->statement['bad_data'].mysql_error());
      //  mysql_select_db($this->db_name, $this->con) or die($this->statement['bad_base'].mysql_error());
      //  mysql_query('SET character_set_connection=utf8');
      //  mysql_query('SET character_set_client=utf8');
      //  mysql_query('SET character_set_results=utf8');
        $this->connected=1;
    }
    
    private function close(){
        if (($this->connected==1) and ($this->closeConnection)){
            mysql_close($this->con);
            $this->connected=0;
        }        
    }    
    
    public function checkConnection(){
        if ($this->connected==0){
            $this->open();
        }
    }
    
    public function tables(){
        $this->checkConnection();
        $sql = "SHOW TABLES FROM $this->db_name";
        $tables = mysql_query($sql);
        $this->close();
        return $tables;
    }

    public function table_exists($table) {
        $this->checkConnection();
        $tables = mysql_list_tables ($this->db_name);
        $this->close();
        while (list($temp)=mysql_fetch_array($tables)){
            if ($temp == $table){
                return TRUE;
            }
        }
        return FALSE;
    }

    public function insert($query){
        $this->checkConnection();
        mysql_query($query) or die (mysql_error());
        $id = mysql_insert_id();
        $this->close();
        return $id;
    }
    
    public function select($query){
        $this->checkConnection();
        
        $temp=$this->con->query($query);
        //$temp=mysql_query($query);
        $this->close();
        return $temp;
    }
    
    public function tables_info(){
        $this->checkConnection();
        $result = $this->query("SHOW TABLE STATUS FROM $this->db_name");
        return $result; 
    }

    public function query($query){
        if ($this->debug=="on") {echo "<br/> <pre>$query</pre> <br/>";}
        echo "<br/> <pre>$query</pre> <br/>";
        $this->checkConnection();
        
      
        
        
        $temp=$this->con->query($query);
        //echo 'test';
        //$temp=mysql_query($query) or die ("<pre>error2 = $query \n \n".mysql_error()."</pre>");
        
       //$this->con->prepare($query);
        
//        if( $this->con->execute() ) {
//                return $stmnt->fetchAll(PDO::FETCH_ASSOC);
//        }
        foreach ($temp as $key ) {
            echo 'fdfsd';
        }
        
        
        //foreach ($temp->fetchAll(PDO::FETCH_ASSOC) as $value) {
            echo 'x';
        //}
        
        
        //$this->close();
        //echo "<br/> temp  = $temp <br/>";
        return $temp;
    }

    public function rlo($query){ //record limit one
        if ($this->debug=="on") {echo "<br/> <pre>$query</pre> <br/>";}
        //echo "<br/> <pre>$query</pre> <br/>";
        $this->checkConnection();
        $temp = mysql_query($query) or die ("<pre>error2 = $query \n \n".mysql_error()."</pre>");
        $this->close();
        while($rek=mysql_fetch_assoc($temp)){$tab=$rek;}
        return $tab;
    }

    public function pagi($query,$rec=25,$max=10){
        echo "<br/> <pre>$query</pre> <br/>";
        require_once 'core/ps_pagi.php';
        $this->checkConnection();
        
        if ($this->debug=="on"){echo "<pre>$query</pre>";}
        $this->pager = new PS_Pagination($this->con,$query,$rec,$max);
        $temp2 = $this->pager->paginate();
        $this->close();//echo 'rrr'.$temp2.'rrr';
        return $temp2;
    }

    public function DuplicateMySQLRecord($table,$id_field,$id){
        $rs = $this->query("SELECT * FROM {$table} WHERE {$id_field}={$id}");
        $original_record = mysql_fetch_assoc($rs);
        $newid = $this->insert("INSERT INTO {$table} (`{$id_field}`) VALUES (NULL)");
        // generate the query to update the new record with the previous values
        $query = "UPDATE {$table} SET ";
        foreach ($original_record as $key => $value) {
            if($key!=$id_field){
                $query.='`'.$key.'` = "'.str_replace('"','\"',$value).'", ';
            }
        }
        $query = substr($query,0,strlen($query)-2); # lop off the extra trailing comma
        $query .= " WHERE {$id_field}={$newid}";
        $this->query($query);
        return $newid;
    }
    
    public function update($tab){
        $query="UPDATE $tab[base] SET ";
        $ile=0;
        foreach ($tab as $key => $value){
            if ($key=="base" or $key=="where") {continue;}
            if ($ile>0) {$query.=", ";}
            $query.="$key = '$value'";
            $ile++;
        }
        $query .= " WHERE ";
        $query .= " ".$tab['where'].";";
        //echo "sql = $sql<br/>";
        $this->checkConnection();
        mysql_query($query) or die (mysql_error());
        $this->close();
    }
    
    public function view($rs){
        while($rek=mysql_fetch_assoc($rs)){
            echo '<pre>'; print_r($rek); echo '</pre>';
        }
    }
    
}

global $sqlconnector; $sqlconnector = new sqlConnector();

?>