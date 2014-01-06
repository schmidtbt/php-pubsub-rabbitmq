<?php

/**
 * @author Revan
 */
class ExchangePool extends Pool {
    
    protected static $_instance;
    
    /**
     *
     * @return ExchangePool
     */
    public static function singleton(){
        if( isset( static::$_instance ) ){            
            return static::$_instance;
        } else {
            static::$_instance = new static();
            return static::$_instance;
        }
    }
    
    public static function acq( $exchangeName = '' ){
        return static::singleton()->safeGet($exchangeName);
    }
    
    /**
     *
     * @param type $queueName
     * @return Exchange 
     */
    public function safeGet( $exchangeName = '' ){
        
        $poolResult = $this->get( $exchangeName );
        if( !$poolResult ){
            // Not yet in here, create
            $Q = new Exchange( $exchangeName );
            parent::add( $exchangeName, $Q );
            return $Q;
        } else {
            if( ! $poolResult instanceof Exchange ){
                throw new PUBSUB_EXCEPTION('Invalid Exchange Returned from Pool' );
            }
            return $poolResult;
        }
        
    }
    
    
}

?>
