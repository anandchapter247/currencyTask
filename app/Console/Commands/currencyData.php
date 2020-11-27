<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currency;
use App\Models\CurrencyHistory;
use Orchestra\Parser\Xml\Facade as XmlParser;

class currencyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily currency price are added';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
                    $data->save();
                }
                if (!CurrencyHistory::where('currency_date', $xml['Date'])->where('currency_id', $value->NumCode)->count()) {
                    $dataHistory = new CurrencyHistory;
                    $dataHistory->currency_id = $value->NumCode;
                    $dataHistory->price = $value->Value;
                    $dataHistory->currency_date = $xml['Date'];
                    $dataHistory->save();
                }
                $this->info('currency recored update');
                
            }
        } 
    }
}
