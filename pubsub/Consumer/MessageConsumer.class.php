<?php

/**
 * @author Revan
 */
class MessageConsumer extends Consumer {
    
    /**
     * @var Message
     */
    protected $_message;
    
    public function __construct($msg) {
        
        //echo "\n------------------------------------\n";
        echo "--->> @". date( 'M d Y H:i:s' ). "";
        try {
            
            $this->_msg = $msg;
            if( $msg instanceof \PhpAmqpLib\Message\AMQPMessage ){
                $this->AMQPMess($msg);
            } else {
                throw new PUBSUB_EXCEPTION( 'Require AMQPMessage' );
            }
        } catch( KoreException $e ){
            $this->nonAMQPMess($e, $msg);
        }
        //echo "------------------------------------";
    }
    
    protected function AMQPMess( $msg ){
        $this->setSelfDestruct();
        $this->_message = Message::read( $msg->body );
        $this->doExecute();
    }
    
    protected function nonAMQPMess( Exception $e, $msg ){
        echo "\n\nBlackholing...\n";
        echo "Failed: ". $e->getMessage();
        $this->ack();
        $this->debugOut();
    }
    
    public function doExecute() {
        
        try {
            try {
                MessageExecute::run( $this->_message );
            } catch( KoreException $e ){
                throw new PUBSUB_QUIT;
            }
            
        } catch( PUBSUB_RETRY $e ){
            return;
        } catch( PUBSUB_QUIT $e ){
            
        }
        $this->ack();
        $this->debugOut();
        echo "\n";
    }
    
    
}

?>
