<?php
// /../controllers/mnb_currency_controller.php

$title = "MNB Currency Rates";

// Adatok lekérése és feldolgozása a SOAP API-val
require_once __DIR__ . '/../models/SoapServerModel.php';

$soapModel = new SoapServerModel();
$currencyPair = 'EUR-HUF';
$date = date('Y-m-d');

// Lekérdezzük az adott nap árfolyamát
$rate = $soapModel->getExchangeRateByCurrencyPair('EUR', 'HUF', $date);

// Az adatokat átadjuk a nézetnek
require __DIR__ . '/../views/mnb-currency.php';
