<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Config file for Yii Documentor
 * 
 * The config file controls the behavior of the Yii Docuementor.
 * The exclcude array is used to prevent some files from generating
 * documentation. The generator does not allow a class name to be
 * used again in another file, so it is necessary to exclude duplicate
 * classes, or refactor the class name to a new name.
 */
return array(
  'exclude' => array('modules'),
);
?>
