</body>
</html>
<?
if (isset($dbconn)){
  if(pg_connection_status($dbconn) == true){
  pg_clode($dbconn);
  }
}
?>