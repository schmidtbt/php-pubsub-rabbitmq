<?php

/**
 * @author Revan
 */
class Worker {
    
    protected static $_log = '/home/Revan/logs/rabbit';
    
    public static function exec( $input ){
        
        echo 'running..';
        var_dump( $input );
        
    }
    
    public static function printOut(){
        echo time();
    }
    
    public static function logmsg( $msg ){
        Pub::log($msg);
    }
    
    public static function log( $msg ){
        ini_set('error_log', static::$_log );
        error_log( "RABBIT: ". $msg ."" );
    }
    
    protected static function errorLog( $msg ){
        Pub::log(__CLASS__.": ".$msg);
    }
}

?>
