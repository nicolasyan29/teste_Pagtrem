<?php
require_once __DIR__ . '/../public/db.php';
session_unset(); session_destroy();
header('Location: login.php'); exit;
