<?php

/**
 * @author Revan
 */
class LogConsumer extends MessageConsumer {
    
    
    public function doExecute() {
        
        try {
            try {
                $params = $this->_message->getParams();
                echo "\t".$params."\n";
                MessageExecute::run( $this->_message );
            } catch( KoreException $e ){
                throw new PUBSUB_QUIT;
            }
            
        } catch( PUBSUB_RETRY $e ){
            return;
        } catch( PUBSUB_QUIT $e ){
            
        }
        $this->ack();
    }
    
}

?>
