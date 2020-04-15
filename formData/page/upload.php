<?php

move_uploaded_file($_FILES['file']['tmp_name'], "pics/" . $_FILES['file']['name']);

?>