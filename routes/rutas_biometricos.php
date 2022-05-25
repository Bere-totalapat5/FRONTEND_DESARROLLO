<?php

Route::post("/biometricos/subir_huella/", "biometricos\biometricos@subir_huella") -> name("bimetricos.subir_huella");
Route::post("/biometricos/subir_firma/", "biometricos\biometricos@subir_firma") -> name("bimetricos.subir_firma");