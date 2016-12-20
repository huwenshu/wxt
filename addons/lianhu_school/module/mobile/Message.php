<?php
$result       = $this->mobile_from_find_student();
$class_message= D("message");
$list         = $class_message->getStudentList($result['student_id']);

