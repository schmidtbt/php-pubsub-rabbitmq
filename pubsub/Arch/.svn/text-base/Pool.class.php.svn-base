<?php

/**
 * @author Revan
 */
class Pool {
    
    protected $_available;
    
    protected function __construct() {
        $this->_available = array();
    }
    
    public function add( $key, $entry ){
        if( $this->get($key) ){
            return false;
        } else {
            $this->_available[$key] = $entry;
        }
    }
    
    public function get( $key ){
        if( isset( $this->_available[$key] ) ){
            return $this->_available[$key];
        } else {
            return false;
        }
    }
    
    
}

?>
