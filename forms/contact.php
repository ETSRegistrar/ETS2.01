<?php
http_response_code(410);
header('Content-Type: text/plain; charset=utf-8');
echo "This contact endpoint has been disabled. The repository was cleared for a new author.\n";
exit;
?>
