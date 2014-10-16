<?php

// Remove WordPress Version Number
if ((bool) get_option('remove-generator')) add_filter('the_generator', create_function(null, 'return false;'));
