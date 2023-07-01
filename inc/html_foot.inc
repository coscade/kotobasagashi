</body>
</html>
<?php
if (isset($dbconn)){
  if(pg_connection_status($dbconn) == true){
  pg_clode($dbconn);
  }
}
?>