<?php

/**
 * @author Revan
 */
class Channel {
    
    protected $_connection;
    protected $_channel;
    protected static $instance;
    
    private function __construct() {
        $this->connect();
    }
    
    /**
     * 
     * @return Channel 
     */
    public static function singleton(){
        if( self::$instance instanceof Channel ){
            return self::$instance;
        } else {
            self::$instance = new Channel();
            return self::$instance;
        }
    }
    
    protected function connect(){
        $this->_connection = new PhpAmqpLib\Connection\AMQPConnection(
                RabbitConfig::HOST, 
                RabbitConfig::PORT, 
                RabbitConfig::USER, 
                RabbitConfig::PASS, 
                RabbitConfig::VHOST);
        
        $this->_channel = $this->_connection->channel();
    }
    
    /**
     *
     * @return PhpAmqpLib\Channel\AMQPChannel
     */
    public function channel(){
        return $this->_channel;
    }
    
}

?>
