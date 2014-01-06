<?php

define( 'PUBDEBUG', true );

/**
 * @author Revan
 */
class Pub {
    
    public static function send( Exchange $exchange, $message, $routing_key = '' ) {
        if( PUBDEBUG ){
            if( $message instanceof Message ){
                try {
                    MessageExecute::run($message);
                }catch( KoreException $e ){
                    echo $e->getMessage();
                }
            }
        } else {
            $chan = Channel::singleton();
            $msg = new PhpAmqpLib\Message\AMQPMessage($message, array('content_type' => 'text/plain', 'delivery-mode' => 1));
            //$chan->channel()->basic_publish( $msg, $exchange->getName() );
            $chan->channel()->basic_publish($msg,  $exchange->getName(), $routing_key);
        }
    }
    
    public static function sendX( $exchangeName, $message, $routing_key = '' ){
        static::send( ExchangePool::singleton()->safeGet( $exchangeName ), $message, $routing_key );
    }
    
	public static function sendMsg( Exchange $exchange, Message $message, $routing_key = '' ){
		static::send( $exchange, $message, $routing_key );
	}
    
    public static function log( $msg ){
        if( PUBDEBUG ){
            echo "\n\n". $msg ."\n\n";
        } else {
            Pub::send(ExchangePool::singleton()->safeGet('koreLog'), Message::createLog($msg) , 'log' );
        }
        
    }
}

?>
