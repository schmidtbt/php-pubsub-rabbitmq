<?php

/**
 * @author Revan
 */
class ConsumerExecution {
    
    protected static $_default = 'MessageConsumer::build';
    
    protected static $_pairs = array( 'log' => 'LogConsumer::build' );
    
    public static function start( $queue ){
        if( isset( static::$_pairs[$queue] ) ){
            print "\n\nUsing: ".static::$_pairs[$queue]." \n\n";
            Sub::consumeNoBuild( $queue, static::$_pairs[$queue] );
        } else {
            print "\n\nUsing default Consumer\n";
            Sub::consumeNoBuild( $queue, static::$_default );
        }
        /*
        foreach( static::$_pairs as $queue => $callback ){
            Sub::consumeX( $queue, $callback );
        }
        */
    }
    
}

?>
