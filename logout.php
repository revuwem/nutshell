<?php

// Скрипт реализовывает выход из учетной записи пользователя, удаляется пользовательская сессия
session_start();

session_destroy();

header('location:login.php');
?>