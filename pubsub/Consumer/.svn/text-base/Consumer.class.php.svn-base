<?php

/**
 * @author Revan
 */
abstract class Consumer {
    
    /**
     *
     * @var PhpAmqpLib\Message\AMQPMessage
     */
    protected $_msg;
    
    public static function build($msg){
        return new static($msg);
    }
    
    public function __construct( $msg ){
        $this->_msg = $msg;
        $this->setSelfDestruct();
        $this->doExecute();
    }
    
    abstract public function doExecute(); // Override in base classes
    
    public function setSelfDestruct(){
        $msg = $this->_msg;
        if( $msg instanceof PhpAmqpLib\Message\AMQPMessage ){
            if ($msg->body === 'quit') {
                $msg->delivery_info['channel']->
                    basic_cancel($msg->delivery_info['consumer_tag']);
            }
        }
    }
    
    public function ack(){
        $msg = $this->_msg;
        if( $msg instanceof PhpAmqpLib\Message\AMQPMessage ){            
            $msg->delivery_info['channel']->
                basic_ack($msg->delivery_info['delivery_tag']);
        }
    }
    
    public function debugOut(){
        $msg = $this->_msg;
        //echo "\nOriginal Message Reads:\n";
        if( $msg instanceof PhpAmqpLib\Message\AMQPMessage ){       
            echo " ".$this->_msg->body . "";
        } else {
            var_dump( $this->_msg );
        }
    }
}

?>
