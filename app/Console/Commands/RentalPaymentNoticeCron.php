<?php

namespace App\Console\Commands;

use App\Models\NotificationRecepient;
use App\Models\Vendor;
use App\Repositories\VehicleRentalRecordRepository;
use App\Services\Api\WhatsappService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RentalPaymentNoticeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rentalpaymentnotice:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send vehicle rental payment notifications to the owner every day.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vehicleRentalRecordRepository = new VehicleRentalRecordRepository();
        $dueVehicleRentalRecords = $vehicleRentalRecordRepository->getDueVehicleRentalRecords();

        if ($dueVehicleRentalRecords->count() > 0) {
            $msgHeader = 'Pemberitahuan Rental Kendaraan Jatuh Tempo :'.PHP_EOL.PHP_EOL;

            $msgBody = '';
            foreach ($dueVehicleRentalRecords as $record) {
                $vendorName = '';
                $vendorPhoneNumber = '';
                $vehicleType = '';
                $vehicleName = '';
                if ($record->truck_id) {
                    $vendor = Vendor::find($record->truck->vendor_id);
                    $vendorName = $vendor->name;
                    $vendorPhoneNumber = $vendor->phone ? ' ('.$vendor->phone.')' : '';

                    $vehicleType = 'Truk';
                    $vehicleName = $record->truck->brand.' '.$record->truck->model.' ('.$record->truck->production_year.')';
                } else {
                    $vendor = Vendor::find($record->heavyVehicle->vendor_id);
                    $vendorName = $vendor->name;
                    $vendorPhoneNumber = $vendor->phone ? ' ('.$vendor->phone.')' : '';

                    $vehicleType = 'Kendaraan Berat';
                    $vehicleName = $record->heavyVehicle->brand.' '.$record->heavyVehicle->model.' ('.$record->heavyVehicle->production_year.')';
                }

                $startDate = date('d-M-Y', strtotime($record->start_date));
                $endDate = date('d-M-Y', strtotime($record->start_date.' + '.$record->rental_duration.' days'));
                $rentalCost = number_format($record->rental_cost, 0, ',', '.');
                $remarks = $record->remarks ? 'Catatan : '.$record->remarks : '';

                $msgData =
                    <<< EOT
                    Kode Sewa Kendaraan : $record->code
                    Vendor : $vendorName $vendorPhoneNumber
                    Jenis Kendaraan : $vehicleType
                    Kendaraan : $vehicleName
                    Tanggal Mulai : $startDate
                    Durasi Sewa : $record->rental_duration hari
                    Tanggal Selesai : $endDate
                    Biaya Sewa : *RP. $rentalCost,-*
                    $remarks
                    EOT;

                $msgBody = $msgBody.$msgData.PHP_EOL.PHP_EOL;
            }

            $msgFooter = 'Mohon segera melakukan pembayaran untuk menghindari denda. Terima kasih.';
        }

        $whatsapp = new WhatsappService();

        $numbers = NotificationRecepient::where('is_active', true)->pluck('phone_number')->toArray();

        $message = $msgHeader.$msgBody.$msgFooter;

        if ($dueVehicleRentalRecords->count() > 0) {
            foreach ($numbers as $number) {
                $whatsapp->sendMessage($number, $message);
            }
        }

    }
}
