<?php

/**
 * @author Revan
 */
class RabbitConsumer extends Consumer {
    
    public function doExecute(){
        $this->ack();
        $this->debugOut();
    }
    
}

?>
