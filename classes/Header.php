<?php
    class Header
    {
        private $logo;
        
        public function __construct($logo="")
        {
            $this->logo = $logo;
        }
        public function get_logo()
        {
            $logo =  $this->logo;
            
            echo "<img class='col-8 col-sm-6 col-md-4 col-xl-3' src='$logo' alt='logo.png'>";
        }
    }
?>

