<?php

echo get_string('ratingtime','local_helloworld');
echo '<br/>';

$grade = 20.00 / 3;
echo format_float($grade, 3);
echo '<br/>';
