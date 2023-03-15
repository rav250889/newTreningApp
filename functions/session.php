<?php
    function start_session()
    {
        session_start();
    
        if(isset($_SESSION['initiate']))
        {
            session_regenerate_id();
            $new_session_id = session_id;
            session_write_close();
            session_id($new_session_id);
            session_start();

            $_SESSION['initiate'] = 1;
        }
    }
?>

