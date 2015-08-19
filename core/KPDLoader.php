<?php
/**
 * Class KPDLoader
 */

abstract class KPDLoader {
    protected function __construct(){
        if ( is_admin() ) :
            $this->admin();
        else:
            $this->site();
            endif;
        $this->all();
        add_action('plugins_loaded', array(&$this, 'pluginsLoaded'));
    }
    abstract protected function admin();
    abstract protected function site();
    abstract protected function all();
    abstract public function pluginsLoaded();
}