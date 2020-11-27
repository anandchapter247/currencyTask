<?php

namespace Database\Seeders;
use Orchestra\Parser\Xml\Facade as XmlParser;

use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Models\CurrencyHistory;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!User::count()) {
            \App\Models\User::factory(20)->create();
        }        

        $xml = file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp');
        $xml = simplexml_load_string($xml);
             
        if (!empty($xml)) {
            foreach ($xml as $key=>$value) {
                if (!Currency::where('ID', $value[0]['ID'])->count()) {
                    $data = new Currency;
                    $data->ID = $value[0]['ID'];
                    $data->NumCode = $value->NumCode;
                    $data->CharCode = $value->CharCode;
                    $data->Nominal = $value->Nominal;
                    $data->Name = $value->Name;
                // $data->Value = $value->Value;
                    $data->save();
                }

                $dataHistory = new CurrencyHistory;
                $dataHistory->currency_id = $value->NumCode;
                $dataHistory->price = $value->Value;
                $dataHistory->currency_date = $xml['Date'];
                $dataHistory->save();
            }
        }     
    }
}

