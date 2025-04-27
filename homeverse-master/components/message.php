<?php

// Success message
if (isset($success_msg) && is_array($success_msg)) {
   foreach ($success_msg as $message) {
      echo '<script>swal("' . htmlspecialchars($message, ENT_QUOTES) . '", "", "success");</script>';
   }
}

// Warning message
if (isset($warning_msg) && is_array($warning_msg)) {
   foreach ($warning_msg as $message) {
      echo '<script>swal("' . htmlspecialchars($message, ENT_QUOTES) . '", "", "warning");</script>';
   }
}

// Info message
if (isset($info_msg) && is_array($info_msg)) {
   foreach ($info_msg as $message) {
      echo '<script>swal("' . htmlspecialchars($message, ENT_QUOTES) . '", "", "info");</script>';
   }
}

// Error message
if (isset($error_msg) && is_array($error_msg)) {
   foreach ($error_msg as $message) {
      echo '<script>swal("' . htmlspecialchars($message, ENT_QUOTES) . '", "", "error");</script>';
   }
}

?>
