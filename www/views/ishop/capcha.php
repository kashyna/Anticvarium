<?php
  $number_1 = rand(1, 100); // ���������� 1-� ��������� �����
  $number_2 = rand(1, 100); // ���������� 2-� ��������� �����
  $_SESSION['rand_code'] = $number_1 + $number_2; // ���������� �� ����� � ������
  $dir = "fonts/"; // ���������� � ��������
  $image = imagecreatetruecolor(200, 60); // ������ �����������
  $color = imagecolorallocate($image, 200, 100, 90); // ����� 1-� ����
  $white = imagecolorallocate($image, 255, 255, 255); // ����� 2-� ����
  imagefilledrectangle($image, 0, 0, 399, 99, $white); // ������ ����� � ����� �����
  imagettftext ($image, 30, 0, 10, 40, $color, $dir."verdana.ttf", "$number_1 + $number_2"); // ����� �����
  header("Content-type: image/png"); // �������� ��������� � ���, ��� ��� ����������� png
  imagepng($image); // ������� �����������
?>