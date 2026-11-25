<?php

session_start();

$koneksi = mysqli_connect("localhost", "root", "", "tugasin");

if (!$koneksi) {
  die("Koneksi database gagal: " . mysqli_connect_error());
}
