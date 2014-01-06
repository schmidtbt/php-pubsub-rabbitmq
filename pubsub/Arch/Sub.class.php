<?php

/**
 * @author Revan
 */
class Sub {
    
    protected $_queue;
    
    public static function consume( Queue $queue, $callback, $name = 'Default' ){
        static::doConsume($queue->getName(), $callback, $name);
    }
    
    public static function consumeX( $queueName, $callback, $name = 'Default' ){
        $Q = QueuePool::singleton()->safeGet($queueName);
        return static::consume($Q, $callback, $name);
    }
    
    public static function consumeNoBuild( $queueName, $callback, $name = 'Default' ){
        static::doConsume($queueName, $callback, $name);
    }
    
    public static function consumeTimer( Queue $queue, $callback, $doForInSeconds, $name = 'Default' ){
        $chan = Channel::singleton();
        $chan->channel()->basic_consume( $queue->getName(), $name, false, false, false, false, $callback );
        static::doWaitTimer( $chan, $doForInSeconds );
    }
    
    protected static function doWait( Channel $chan ){
        while( count( $chan->channel()->callbacks ) ){
            $chan->channel()->wait();
            ob_flush();
        }
    }
    
    protected static function doWaitTimer( Channel $chan, $maxDuration ){
        $quitTime = time() + $maxDuration;
        while( count( $chan->channel()->callbacks ) && time() < $quitTime ){
            $chan->channel()->wait();
        }
    }
    
    protected static function doConsume( $queueName, $callback, $name ){
        $chan = Channel::singleton();
        $chan->channel()->basic_consume( $queueName, $name, false, false, false, false, $callback );
        static::doWait( $chan );
    }
    
}

?>
