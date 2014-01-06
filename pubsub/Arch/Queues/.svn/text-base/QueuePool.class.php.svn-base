<?php

/**
 * @author Revan
 */
class QueuePool extends Pool {
    
    protected static $_instance;
    
    const BASIC         = 0;
    const AUTODELETE    = 1;
    const EXCLUSIVE     = 2;
        
    
    /**
     *
     * @return QueuePool
     */
    public static function singleton(){
        if( isset( static::$_instance ) ){            
            return static::$_instance;
        } else {
            static::$_instance = new static();
            return static::$_instance;
        }
    }
    
    /**
     *
     * @param type $queueName
     * @return Queue
     */
    public function safeGet( $queueName, $type = 0 ){
        
        $poolResult = $this->get( $queueName );
        if( !$poolResult ){
            $classType = $this->switchType($type);
            // Not yet in here, create
            $Q = new $classType( $queueName );
            parent::add( $queueName, $Q );
            return $Q;
        } else {
            return $poolResult;
        }
        
    }
    
    protected function switchType( $queueType ){
        
        switch( $queueType ){
            
            case QueuePool::BASIC:
                return 'Queue';
                break;
            case QueuePool::AUTODELETE:
                return 'AutoDeleteQueue';
                break;
            case QueuePool::EXCLUSIVE:
                return 'ExclusiveQueue';
                break;
            default:
                throw new PUBSUB_EXCEPTION('Invalid Queue Type' );
            
        }
        
    }
    
    
}

?>
