<?php
    class Head
    {
        private $title;
        private $css;
        
        public function __construct($title="", $css="")
        {
            $this->title = $title;
            $this->css = $css;
        }
        public function get_head()
        {
	    echo "<head>";
            echo "<title>$this->title</title>";
            echo "<meta name='author' content='Rafał Wałach tel. (48)730 341 343'>";
            echo "<meta name='description' content='Aplikacja pozwala na tworzenie własnego planu treningowego. Posiada możliwość zliczania wykonanych serii treningowych'>";
            echo "<link rel='icon' type='image/x-icon' href=''/>";
            echo "<link rel='stylesheet' href='$this->css'>";
	    echo "</head>";	
        }
        
        public function additional_css($path)
        {
            echo "<link rel='stylesheet' href='$path'>";
        }
    }
?>

	
	
	
	
