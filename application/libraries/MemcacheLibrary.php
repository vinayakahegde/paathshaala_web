<?php

class MemcacheLibrary{
    
    public $memcache = FALSE;
    
    public function __construct() {
        /* $server = _MEMCACHE_SERVER_IP;
        $port   = _MEMCACHE_SERVER_PORT; */
        $this->memcache = new Memcached("PAATHSHAALA");
        $this->memcache->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);

	$this->memcache->addServers(
	   array( array(_MEMCACHE_SERVER_IP, _MEMCACHE_SERVER_PORT) )
	);
        
        //$this->memcache->connect($server, $port);

        return $this->memcache;
    }
    
    public function isMemcacheAvailable(){
        if( $this->memcache === FALSE ){
            return false;
        }
        return true;
    }
    
    public function setKey( $key_name, $key_value, $retain_time = _MEMCACHE_ENTRY_RETAIN_PERIOD ){
        //$this->memcache->set( $key_name, $key_value, 0, $retain_time ) or die ("Failed to save data at the server") ;
        $this->memcache->set( $key_name, $key_value, time() + $retain_time ) or die ("Failed to save data at the server") ;
    }
    
    public function getKey( $key_name ){
        return $this->memcache->get( $key_name );
    }
    
    public function deleteKey( $key_name ){
        $deleted = $this->memcache->delete( $key_name );
        return $deleted;
    }
    
    public function multiSetKey( $array ){
        $this->memcache->setMulti( $array, time() + _MEMCACHE_ENTRY_RETAIN_PERIOD ) or die ("Failed to save data at the server") ;
        /*$status = $this->memcache->getResultCode();
        error_log("multiSetKey status : " . $status);*/
    }
    
    public function multiDeleteKey( $array_keys ){
        $this->memcache->deleteMulti( $array_keys );
        /*$status = $this->memcache->getResultCode();
        error_log("multiDeleteKey status : " . $status);*/
    }
}

?>