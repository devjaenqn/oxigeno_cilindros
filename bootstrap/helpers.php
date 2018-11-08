<?php
  if (! function_exists('fill_zeros')) {
      function fill_zeros($number, $zeros = 10)
      {
        $num = number_format($number, 0, '', '');
        return str_pad($num, $zeros, '0', STR_PAD_LEFT);
      }
  }

 ?>