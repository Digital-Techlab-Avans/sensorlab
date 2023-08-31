<?php

    namespace Database\Seeders;

    use Database\Factories\CategoryFactory;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class CategorySeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $nameColumn = 'name';
            $descriptionColumn = 'description';
            $img_nameColumn = 'img_name';

            $category_information = [
                [$nameColumn => 'Microcontrollers', $descriptionColumn => 'Een microcontroller is een geïntegreerde schakeling met een microprocessor die wordt gebruikt om elektronische apparatuur te besturen.', $img_nameColumn => 'microcontroller1.jpg'],
                [$nameColumn => 'Development Boards', $descriptionColumn => 'Een development board is een printplaat met daarin een microprocessor en de minimale ondersteuningslogica die nodig is voor een elektronische ingenieur of iemand die kennis wil maken met de microprocessor op het bord en deze wil leren programmeren. Het dient ook gebruikers van de microprocessor als een methode om toepassingen in producten te prototypen.', $img_nameColumn => 'DevelopmentBoard.jpg'],
                [$nameColumn => 'Sensoren', $descriptionColumn => 'ensoren zijn elektronische apparaten die worden gebruikt om fysieke of chemische eigenschappen van de omgeving te meten en te detecteren. Ze zetten deze metingen om in een elektrisch signaal dat kan worden gelezen door een microcontroller of een computer. Er zijn verschillende soorten sensoren beschikbaar, elk met hun eigen functie en toepassingsgebied.', $img_nameColumn => 'sensor.jpg'],
                [$nameColumn => 'Lampjes', $descriptionColumn => 'Een kleine lichtbron.', $img_nameColumn => 'Led.jpg'],
            ];

            foreach ($category_information as $category) {
                CategoryFactory::new()->create($category);
            }
        }
    }
