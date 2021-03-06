<?php

/**
 * @author Revan
 */
class Message {
    
    protected $_msgString;
    
    protected $_method;
    protected $_params;
    
    private function __construct(){}
    
    public static function create( $method, $params = '' ){
        $obj = new Message();
        $obj->_method = $method;
        $obj->_params = $params;
        $obj->genString();
        return $obj;
    }
    
    public static function read( $msgJson ){
        if( !is_string( $msgJson ) ){
            throw new PUBSUB_EXCEPTION('Must provide a String JSON message' );
        }
        $msg = json_decode($msgJson, JSON_FORCE_OBJECT);
        if( is_null( $msg ) ){
            var_dump( $msgJson );
            throw new PUBSUB_EXCEPTION('Message could not be converted from JSON' );
        }
        $obj = new Message();
        if( !isset( $msg['method'] ) || !isset( $msg['param'] ) ){
            throw new PUBSUB_EXCEPTION( 'Invalid JSON syntax. No method/param' );
        }
        $obj->_method = $msg['method'];
        $obj->_params = $msg['param'];
        return $obj;
    }
    
    public static function createLog( $msg ){
        return Message::create( array( 'Worker', 'log' ), $msg );
    }
    
    protected function genString(){
        $obj = array();
        $obj['method'] = $this->_method;
        $obj['param'] = $this->_params;
        $this->_msgString = json_encode($obj);
    }
    
    public function disp(){
        return $this->_msgString;
    }
    
    public function __toString() {
        return $this->_msgString;
    }
    
    public function getParams(){
        return $this->_params;
    }
    
    public function getMethod(){
        return $this->_method;
    }
}

?>
