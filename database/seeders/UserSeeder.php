<?php

    namespace Database\Seeders;

    use Database\Factories\UserFactory;
    use Hash;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class UserSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            $emailColumn = 'email';
            $nameColumn = 'name';
            $adminColumn = 'is_admin';
            $passwordColumn = 'password';

            $users_information = [
                [$emailColumn => 'f.bos' . '@student.avans.nl', $nameColumn => 'Fenna Bos'],
                [$emailColumn => 'l.van.der.wal' . '@student.avans.nl', $nameColumn => 'Lotte van der Wal'],
                [$emailColumn => 'e.hoekstra' . '@student.avans.nl', $nameColumn => 'Elijah Hoekstra'],
                [$emailColumn => 'b.van.dam' . '@student.avans.nl', $nameColumn => 'Boris van Dam'],
                [$emailColumn => 'r.de.bruijn' . '@student.avans.nl', $nameColumn => 'Rosa de Bruijn'],
                [$emailColumn => 'y.de.bruin' . '@student.avans.nl', $nameColumn => 'Yara de Bruin'],
                [$emailColumn => 'r.hendriks' . '@student.avans.nl', $nameColumn => 'Remi Hendriks'],
                [$emailColumn => 'g.van.den.brink' . '@student.avans.nl', $nameColumn => 'Guus van den Brink'],
                [$emailColumn => 's.de.leeuw' . '@student.avans.nl', $nameColumn => 'Sophie de Leeuw'],
                [$emailColumn => 's.van.vliet' . '@student.avans.nl', $nameColumn => 'Sophia van Vliet'],
                [$emailColumn => 'r.van.der.meer' . '@student.avans.nl', $nameColumn => 'Rosie van der Meer'],
                [$emailColumn => 'b.de.graaf' . '@student.avans.nl', $nameColumn => 'Bodhi de Graaf'],
                [$emailColumn => 'k.smits' . '@student.avans.nl', $nameColumn => 'Kyan Smits'],
                [$emailColumn => 'l.willemsen' . '@student.avans.nl', $nameColumn => 'Levi Willemsen'],
                [$emailColumn => 'm.de.wit' . '@student.avans.nl', $nameColumn => 'Mads de Wit'],
                [$emailColumn => 'f.molenaar' . '@student.avans.nl', $nameColumn => 'Fedde Molenaar'],
                [$emailColumn => 'a.van.der.laan' . '@student.avans.nl', $nameColumn => 'Arthur van der Laan'],
                [$emailColumn => 'f.smeets' . '@student.avans.nl', $nameColumn => 'Fiene Smeets'],
                [$emailColumn => 'a.timmermans' . '@student.avans.nl', $nameColumn => 'Anne Timmermans'],
                [$emailColumn => 'w.van.der.horst' . '@student.avans.nl', $nameColumn => 'Wolf van der Horst'],
                [$emailColumn => 'v.van.wijk' . '@student.avans.nl', $nameColumn => 'Veerle van Wijk'],
                [$emailColumn => 'i.boer' . '@student.avans.nl', $nameColumn => 'Iris Boer'],
                [$emailColumn => 'y.groen' . '@student.avans.nl', $nameColumn => 'Yoran Groen'],
                [$emailColumn => 'j.kuipers' . '@student.avans.nl', $nameColumn => 'Julie Kuipers'],
                [$emailColumn => 'm.postma' . '@student.avans.nl', $nameColumn => 'Mees Postma'],
                [$emailColumn => 'j.van.der.meer' . '@student.avans.nl', $nameColumn => 'Jesse van der Meer'],
                [$emailColumn => 'j.de.vries' . '@student.avans.nl', $nameColumn => 'Jip de Vries'],
                [$emailColumn => 's.van.der.kolk' . '@student.avans.nl', $nameColumn => 'Senna van der Kolk'],
                [$emailColumn => 'e.van.der.laan' . '@student.avans.nl', $nameColumn => 'Eva van der Laan'],
                [$emailColumn => 'j.gerritsen' . '@student.avans.nl', $nameColumn => 'Juul Gerritsen'],
                [$emailColumn => 's.van.doorn' . '@student.avans.nl', $nameColumn => 'Suze van Doorn'],
                [$emailColumn => 'j.huisman' . '@student.avans.nl', $nameColumn => 'Joshua Huisman'],
                [$emailColumn => 'o.prins' . '@student.avans.nl', $nameColumn => 'Otis Prins'],
                [$emailColumn => 'd.de.ruiter' . '@student.avans.nl', $nameColumn => 'Damian de Ruiter'],
                [$emailColumn => 'j.koster' . '@student.avans.nl', $nameColumn => 'Jan Koster'],
                [$emailColumn => 'o.peters' . '@student.avans.nl', $nameColumn => 'Owen Peters'],
                [$emailColumn => 'a.janssen' . '@student.avans.nl', $nameColumn => 'Ace Janssen'],
                [$emailColumn => 'e.dijkstra' . '@student.avans.nl', $nameColumn => 'Eva Dijkstra'],
                [$emailColumn => 'm.de.vos' . '@student.avans.nl', $nameColumn => 'Mila de Vos'],
                [$emailColumn => 'l.jacobs' . '@student.avans.nl', $nameColumn => 'Livia Jacobs'],
                [$emailColumn => 'r.verbeek' . '@student.avans.nl', $nameColumn => 'Roos Verbeek'],
                [$emailColumn => 'l.hermans' . '@student.avans.nl', $nameColumn => 'Lewis Hermans'],
                [$emailColumn => 's.schouten' . '@student.avans.nl', $nameColumn => 'Sarah Schouten'],
                [$emailColumn => 's.van.der.meulen' . '@student.avans.nl', $nameColumn => 'Saar van der Meulen'],
                [$emailColumn => 'm.visser' . '@student.avans.nl', $nameColumn => 'Merel Visser'],
                [$emailColumn => 'n.van.leeuwen' . '@student.avans.nl', $nameColumn => 'Noor van Leeuwen'],
                [$emailColumn => 'o.scholten' . '@student.avans.nl', $nameColumn => 'Olivia Scholten'],
                [$emailColumn => 'i.koning' . '@student.avans.nl', $nameColumn => 'Ivy Koning'],
                [$emailColumn => 'm.van.der.veen' . '@student.avans.nl', $nameColumn => 'Milan van der Veen'],
                [$emailColumn => 'h.van.den.bosch' . '@student.avans.nl', $nameColumn => 'Hans van den Bosch'],
                [$emailColumn => 'm.willems' . '@student.avans.nl', $nameColumn => 'Milo Willems'],
                [$emailColumn => 'e.jansen' . '@student.avans.nl', $nameColumn => 'Ella Jansen'],
                [$emailColumn => 'l.driessen' . '@student.avans.nl', $nameColumn => 'Lenn Driessen'],
                [$emailColumn => 'f.brouwer' . '@student.avans.nl', $nameColumn => 'Fleur Brouwer'],
                [$emailColumn => 'm.meijer' . '@student.avans.nl', $nameColumn => 'Maeve Meijer'],
                [$emailColumn => 'n.blom' . '@student.avans.nl', $nameColumn => 'Naomi Blom'],
                [$emailColumn => 'l.de.jonge' . '@student.avans.nl', $nameColumn => 'Laurens de Jonge'],
                [$emailColumn => 'r.de.vries' . '@student.avans.nl', $nameColumn => 'Revi de Vries'],
                [$emailColumn => 'j.de.koning' . '@student.avans.nl', $nameColumn => 'Jelle de Koning'],
                [$emailColumn => 'p.kuijpers' . '@student.avans.nl', $nameColumn => 'Pepijn Kuijpers'],
                [$emailColumn => 'h.van.den.broek' . '@student.avans.nl', $nameColumn => 'Hidde van den Broek'],
                [$emailColumn => 'j.de.boer' . '@student.avans.nl', $nameColumn => 'Jens de Boer'],
                [$emailColumn => 'z.de.groot' . '@student.avans.nl', $nameColumn => 'Zayn de Groot'],
                [$emailColumn => 'r.maas' . '@student.avans.nl', $nameColumn => 'Ravi Maas'],
                [$emailColumn => 'm.smit' . '@student.avans.nl', $nameColumn => 'Maurice Smit'],
                [$emailColumn => 'l.bakker' . '@student.avans.nl', $nameColumn => 'Lieke Bakker'],
                [$emailColumn => 'k.van.dongen' . '@student.avans.nl', $nameColumn => 'Kiki van Dongen'],
                [$emailColumn => 'c.peeters' . '@student.avans.nl', $nameColumn => 'Charlotte Peeters'],
                [$emailColumn => 'b.de.jong' . '@student.avans.nl', $nameColumn => 'Boaz de Jong'],
                [$emailColumn => 'l.van.der.velden' . '@student.avans.nl', $nameColumn => 'Lars van der Velden'],
                [$emailColumn => 't.dekker' . '@student.avans.nl', $nameColumn => 'Tom Dekker'],
                [$emailColumn => 'f.evers' . '@student.avans.nl', $nameColumn => 'Finn Evers'],
                [$emailColumn => 'j.van.de.ven' . '@student.avans.nl', $nameColumn => 'Jurre van de Ven'],
                [$emailColumn => 'l.kuiper' . '@student.avans.nl', $nameColumn => 'Liv Kuiper'],
                [$emailColumn => 'e.bosman' . '@student.avans.nl', $nameColumn => 'Elise Bosman'],
                [$emailColumn => 'f.vos' . '@student.avans.nl', $nameColumn => 'Floris Vos'],
                [$emailColumn => 't.van.den.berg' . '@student.avans.nl', $nameColumn => 'Tessa van den Berg']
            ];

            foreach ($users_information as $user_information) {
                UserFactory::new()->create($user_information);

            }

            UserFactory::new()->create([
                $emailColumn => 'ppj.wilting' . '@avans.nl',
                $nameColumn => 'Pleun Wilting',
                $passwordColumn => 'password',
                $adminColumn => true
            ]);

        }
    }
