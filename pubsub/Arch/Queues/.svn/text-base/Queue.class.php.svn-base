<?php

/**
 * @author Revan
 */
class Queue {
    
    protected $_chan;
    protected $_queueName;
    
    protected static $_passive = false;
    protected static $_durable = false;
    protected static $_exclusive = false;
    protected static $_auto_delete = false;
    
    
    public function __construct( $queueName ){
        $this->_queueName = $queueName;
        $this->_chan = Channel::singleton()->channel();
        $this->queueDeclare($queueName);
        //echo 'created queue ' . $queueName;
    }
    
    public function getName(){
        return $this->_queueName;
    }
    
    
    protected function queueDeclare($queueName) {
        $return = $this->_chan->queue_declare($queueName, static::$_passive, static::$_durable, static::$_exclusive, static::$_auto_delete);
        if( isset( $return[0] ) ){
            $this->_queueName = $return[0];
        }
    }
    
    
}

?>
