<?php
$class_classes = D('classes');
$teacher_info = $this->teacher_mobile_qx();
$list         = $this->getTodayCourse($teacher_info['teacher_id']);