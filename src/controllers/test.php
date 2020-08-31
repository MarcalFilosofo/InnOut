
<pre>
<?php
//cafasfdfa
loadModel('WorkingHours');

$wh = WorkingHours::loadFromUserAndDate(1, date('Y-m-d'));
$li = $wh->getLunchInterval()->format('%H:%I:%S');
print_r($li);




//print_r($t2);