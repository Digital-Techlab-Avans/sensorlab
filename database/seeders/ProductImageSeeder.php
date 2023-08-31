<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class ProductImageSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $product_idColumn = 'product_id';
            $image_nameColumn = 'image_name';
            $priorityColumn = 'priority';

            $product_images_information = [
                [$product_idColumn => 1, $image_nameColumn => 'NeoPixelStick.jpg', $priorityColumn => 1],
                [$product_idColumn => 1, $image_nameColumn => 'NeoPixelStick2.jpg', $priorityColumn => 2],
                [$product_idColumn => 2, $image_nameColumn => 'NeoPixel.jpg', $priorityColumn => 1],
                [$product_idColumn => 2, $image_nameColumn => 'NeoPixel2.jpg', $priorityColumn => 2],
                [$product_idColumn => 3, $image_nameColumn => 'LEDMatrix.jpg', $priorityColumn => 1],
                [$product_idColumn => 4, $image_nameColumn => 'BodemvochtigheidsSensor.jpg', $priorityColumn => 1],
                [$product_idColumn => 5, $image_nameColumn => 'TimeOfLightDistanceSensor.jpg', $priorityColumn => 1],
                [$product_idColumn => 6, $image_nameColumn => '12VoltSpeaker.jpg', $priorityColumn => 1],
                [$product_idColumn => 7, $image_nameColumn => 'MP3Speler.jpg', $priorityColumn => 1],
                [$product_idColumn => 8, $image_nameColumn => 'XBEE.jpg', $priorityColumn => 1],
                [$product_idColumn => 9, $image_nameColumn => '12mmDrukknopVerlicht.jpg', $priorityColumn => 1],
                [$product_idColumn => 10, $image_nameColumn => 'RaspberryPi3.jpg', $priorityColumn => 1],
                [$product_idColumn => 11, $image_nameColumn => 'Powerbank.jpg', $priorityColumn => 1],
                [$product_idColumn => 12, $image_nameColumn => 'TransmissieMotor.jpg', $priorityColumn => 1],
                [$product_idColumn => 13, $image_nameColumn => 'ServoMotor.jpg', $priorityColumn => 1],
                [$product_idColumn => 14, $image_nameColumn => 'USBHub.jpg', $priorityColumn => 1],
                [$product_idColumn => 15, $image_nameColumn => 'ArduinoMega.jpg', $priorityColumn => 1],
                [$product_idColumn => 16, $image_nameColumn => 'ArduinoMKR1000.jpg', $priorityColumn => 1],
                [$product_idColumn => 17, $image_nameColumn => 'ArduinoUno.jpg', $priorityColumn => 1],
                [$product_idColumn => 18, $image_nameColumn => 'ArduinoNano.jpg', $priorityColumn => 1],
                [$product_idColumn => 19, $image_nameColumn => 'Knoppen.jpg', $priorityColumn => 1],
                [$product_idColumn => 20, $image_nameColumn => 'IRAfstandSensor.jpg', $priorityColumn => 1],
            ];

            DB::table('product_images')->insert($product_images_information);

        }
    }
