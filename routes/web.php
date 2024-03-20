<?php

use App\Console\Commands\RentalPaymentNoticeCron;
use App\Repositories\MaterialMovementRepository;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send', function () {
    // $whatsappService = new \App\Services\Api\WhatsappService();
    // // $whatsappService->sendMessage('6285325483259', 'Hello, this is a test message from Laravel!');
    // $whatsappService->sendMessage('6282227637711', 'testttttttt');
    // return 'Message sent!';

    $anu = new RentalPaymentNoticeCron();
    $anu->handle();
});

Route::get('/test/{statistic_type}', function ($statistic_type) {
    $anu = new MaterialMovementRepository();
    $result = $anu->getStatisticTruckPerDayByStation($statistic_type, 'from_start', 'quary'); // Memanfaatkan nilai dari parameter URL

    return $result;
});
