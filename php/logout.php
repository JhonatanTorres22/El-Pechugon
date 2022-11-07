<?php
session_start();

unset($_SESSION['online']);
unset($_SESSION['id']);
unset($_SESSION['usuario']);
unset($_SESSION['is_admin']);

session_destroy();

header('Location: ../admin/login');