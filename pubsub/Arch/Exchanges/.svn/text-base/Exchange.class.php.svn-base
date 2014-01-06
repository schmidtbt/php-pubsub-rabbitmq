<?php

/**
 * @author Revan
 */
class Exchange {
    
    const DIRECT = 'direct';
    const FANOUT = 'fanout';
    const TOPIC = 'topic';
    
    protected $_chan;
    protected $_exchangeName;
    
    protected $_type;
    protected $_queues;
    protected $_properties;
    
    protected $_durable     = false;
    protected $_auto_delete = false;
    
    public function __construct( $exchangeName = '' ){
        $this->_exchangeName = $exchangeName;
        $this->_chan = Channel::singleton()->channel();
        if( $exchangeName != '' ){
            // Deal with the non-default exchange
            $this->getProperties();
            $this->exchangeDeclare($exchangeName);
            $this->bindings();
        }
        //echo 'created exchange ' . $exchangeName;
    }
    
    public function getName(){
        return $this->_exchangeName;
    }
    
    /**
     * Bind a queue which was not originally apart of this Exchanges definition
     * @param Queue $queue 
     */
    public function bindQueue( Queue $queue, $routing_key = '' ){
        $this->bind( $queue->getName(), $routing_key );
    }
    
    protected function exchangeDeclare( $exchangeName ){
        $this->_chan->exchange_declare($exchangeName, $this->_type, false, $this->_durable, $this->_auto_delete);
    }
    
    protected function getProperties(){
        
        $network = RabbitNetworkConfig::$network;
        
        if( isset( $network[$this->_exchangeName] ) ){
            $props = $network[$this->_exchangeName];
            $this->_type = $props['type'];
            $this->_queues = $props['queues'];
            
            if( isset( $props['properties'] ) ){
                
                $declareProps = $props['properties'];

                if( isset( $declareProps['autodelete'] ) ){
                    $this->_auto_delete = $declareProps['autodelete'];
                }

                if( isset( $declareProps['durable'] ) ){
                    $this->_durable = $declareProps['durable'];
                }

            }
        } else {
            throw new PUBSUB_EXCEPTION('Exchange has no Bindings: '.$this->_exchangeName );
        }
    }
    
    
    protected function bindings(){
        
        $queues = $this->_queues; 
        foreach( $queues as $key => $queue ){
            if( is_array( $queue ) ){
                if( sizeof( $queue ) != 1 ){ throw new PUBSUB_EXCEPTION('Size Mismatch: Invalid Definition for Queue Routing Keys'); }
                
                $key = array_keys( $queue );
                
                if( is_array( $queue[$key[0]] ) ){
                    foreach( $queue[$key[0]] as $routingKey ){
                        $this->bind( $key[0], $routingKey );
                    }
                } else {
                    $this->bind( $key[0], $queue[$key[0]] );
                }
                
                
                
            } else {
                if( is_numeric($key) ){
                    $this->bind( $queue );
                } else {
                    throw new PUBSUB_EXCEPTION('Array Structure: Invalid Definition for Queue Routing Keys');
                }
            }
            
        }
    }
    
    protected function bind( $queueName, $routing_key = '' ){
        $queue = QueuePool::singleton()->safeGet( $queueName )->getName();
        $exchange = $this->_exchangeName;
        //$this->_chan->queue_bind( QueuePool::singleton()->safeGet( $queueName )->getName(), $this->_exchangeName );
        $this->_chan->queue_bind( $queue, $exchange, $routing_key );
        
    }
    
}

?>
