<?php

namespace App\Helpers;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\Depreciation;
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Models\Detaillokasi;
use App\Models\JenisPeng;
use App\Models\Keterangan;
use App\Models\Lokasi;
use App\Models\Owner;
use App\Models\Statusp;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Image;
use Carbon\Carbon;

class Helper
{


    /**
     * This is only used for reversing the migration that updates the locale to the 5-6 letter codes from two
     * letter   => , codes. The normal dropdowns use the autoglossonyms in the language files located
     * in res   => ,ources/en-US/localizations.php.
     */ 

    public static function mataUang(){
        $currencies = [
            '' => ['code' => 'Pilih Data', 'title' => '', 'symbol' => '', 'precision' => 0, 'thousandSeparator' => '', 'decimalSeparator' => '', 'symbolPlacement' => ''],
            'ARS' => ['code' => 'ARS', 'title' => 'Argentine Peso', 'symbol' => 'AR$', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'AMD' => ['code' => 'AMD', 'title' => 'Armenian Dram', 'symbol' => 'Դ', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'AWG' => ['code' => 'AWG', 'title' => 'Aruban Guilder', 'symbol' => 'Afl. ', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'AUD' => ['code' => 'AUD', 'title' => 'Australian Dollar', 'symbol' => 'AU$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'BSD' => ['code' => 'BSD', 'title' => 'Bahamian Dollar', 'symbol' => 'B$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'BHD' => ['code' => 'BHD', 'title' => 'Bahraini Dinar', 'symbol' => null, 'precision' => 3, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'BDT' => ['code' => 'BDT', 'title' => 'Bangladesh, Taka', 'symbol' => null, 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'BZD' => ['code' => 'BZD', 'title' => 'Belize Dollar', 'symbol' => 'BZ$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'BMD' => ['code' => 'BMD', 'title' => 'Bermudian Dollar', 'symbol' => 'BD$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'BOB' => ['code' => 'BOB', 'title' => 'Bolivia, Boliviano', 'symbol' => 'Bs', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'BAM' => ['code' => 'BAM', 'title' => 'Bosnia and Herzegovina convertible mark', 'symbol' => 'KM ', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'BWP' => ['code' => 'BWP', 'title' => 'Botswana, Pula', 'symbol' => 'p', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'BRL' => ['code' => 'BRL', 'title' => 'Brazilian Real', 'symbol' => 'R$', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'BND' => ['code' => 'BND', 'title' => 'Brunei Dollar', 'symbol' => 'B$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'CAD' => ['code' => 'CAD', 'title' => 'Canadian Dollar', 'symbol' => 'CA$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'KYD' => ['code' => 'KYD', 'title' => 'Cayman Islands Dollar', 'symbol' => 'CI$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'CLP' => ['code' => 'CLP', 'title' => 'Chilean Peso', 'symbol' => 'CLP$', 'precision' => 0, 'thousandSeparator' => '.', 'decimalSeparator' => '', 'symbolPlacement' => 'before'],
            'CNY' => ['code' => 'CNY', 'title' => 'China Yuan Renminbi', 'symbol' => 'CN¥', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'COP' => ['code' => 'COP', 'title' => 'Colombian Peso', 'symbol' => 'COL$', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'CRC' => ['code' => 'CRC', 'title' => 'Costa Rican Colon', 'symbol' => '₡', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'HRK' => ['code' => 'HRK', 'title' => 'Croatian Kuna', 'symbol' => ' kn', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'CUC' => ['code' => 'CUC', 'title' => 'Cuban Convertible Peso', 'symbol' => 'CUC$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'CUP' => ['code' => 'CUP', 'title' => 'Cuban Peso', 'symbol' => 'CUP$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'CYP' => ['code' => 'CYP', 'title' => 'Cyprus Pound', 'symbol' => '£', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'CZK' => ['code' => 'CZK', 'title' => 'Czech Koruna', 'symbol' => ' Kč', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'DKK' => ['code' => 'DKK', 'title' => 'Danish Krone', 'symbol' => ' kr.', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'DOP' => ['code' => 'DOP', 'title' => 'Dominican Peso', 'symbol' => 'RD$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'XCD' => ['code' => 'XCD', 'title' => 'East Caribbean Dollar', 'symbol' => 'EC$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'EGP' => ['code' => 'EGP', 'title' => 'Egyptian Pound', 'symbol' => 'EGP', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'SVC' => ['code' => 'SVC', 'title' => 'El Salvador Colon', 'symbol' => '₡', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'EUR' => ['code' => 'EUR', 'title' => 'Euro', 'symbol' => ' €', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'GHC' => ['code' => 'GHC', 'title' => 'Ghana, Cedi', 'symbol' => 'GH₵', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'GIP' => ['code' => 'GIP', 'title' => 'Gibraltar Pound', 'symbol' => '£', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'GTQ' => ['code' => 'GTQ', 'title' => 'Guatemala, Quetzal', 'symbol' => 'Q', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'HNL' => ['code' => 'HNL', 'title' => 'Honduras, Lempira', 'symbol' => 'L', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'HKD' => ['code' => 'HKD', 'title' => 'Hong Kong Dollar', 'symbol' => 'HK$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'HUF' => ['code' => 'HUF', 'title' => 'Hungary, Forint', 'symbol' => ' Ft', 'precision' => 0, 'thousandSeparator' => ' ', 'decimalSeparator' => '', 'symbolPlacement' => 'after'],
            'ISK' => ['code' => 'ISK', 'title' => 'Iceland Krona', 'symbol' => ' kr', 'precision' => 0, 'thousandSeparator' => '.', 'decimalSeparator' => '', 'symbolPlacement' => 'after'],
            'INR' => ['code' => 'INR', 'title' => 'Indian Rupee ₹', 'symbol' => '₹', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'IDR' => ['code' => 'IDR', 'title' => 'Indonesia, Rupiah', 'symbol' => 'Rp', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'IRR' => ['code' => 'IRR', 'title' => 'Iranian Rial', 'symbol' => null, 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'JMD' => ['code' => 'JMD', 'title' => 'Jamaican Dollar', 'symbol' => 'J$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'JPY' => ['code' => 'JPY', 'title' => 'Japan, Yen', 'symbol' => '¥', 'precision' => 0, 'thousandSeparator' => ',', 'decimalSeparator' => '', 'symbolPlacement' => 'before'],
            'JOD' => ['code' => 'JOD', 'title' => 'Jordanian Dinar', 'symbol' => null, 'precision' => 3, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'KES' => ['code' => 'KES', 'title' => 'Kenyan Shilling', 'symbol' => 'KSh', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'KWD' => ['code' => 'KWD', 'title' => 'Kuwaiti Dinar', 'symbol' => 'K.D.', 'precision' => 3, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'LVL' => ['code' => 'LVL', 'title' => 'Latvian Lats', 'symbol' => 'Ls', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'LBP' => ['code' => 'LBP', 'title' => 'Lebanese Pound', 'symbol' => 'LBP', 'precision' => 0, 'thousandSeparator' => ',', 'decimalSeparator' => '', 'symbolPlacement' => 'before'],
            'LTL' => ['code' => 'LTL', 'title' => 'Lithuanian Litas', 'symbol' => ' Lt', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'MKD' => ['code' => 'MKD', 'title' => 'Macedonia, Denar', 'symbol' => 'ден ', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'MYR' => ['code' => 'MYR', 'title' => 'Malaysian Ringgit', 'symbol' => 'RM', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'MTL' => ['code' => 'MTL', 'title' => 'Maltese Lira', 'symbol' => 'Lm', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'MUR' => ['code' => 'MUR', 'title' => 'Mauritius Rupee', 'symbol' => 'Rs', 'precision' => 0, 'thousandSeparator' => ',', 'decimalSeparator' => '', 'symbolPlacement' => 'before'],
            'MXN' => ['code' => 'MXN', 'title' => 'Mexican Peso', 'symbol' => 'MX$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'MZM' => ['code' => 'MZM', 'title' => 'Mozambique Metical', 'symbol' => 'MT', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'NPR' => ['code' => 'NPR', 'title' => 'Nepalese Rupee', 'symbol' => null, 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'ANG' => ['code' => 'ANG', 'title' => 'Netherlands Antillian Guilder', 'symbol' => 'NAƒ ', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'ILS' => ['code' => 'ILS', 'title' => 'New Israeli Shekel ₪', 'symbol' => ' ₪', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'after'],
            'TRY' => ['code' => 'TRY', 'title' => 'New Turkish Lira', 'symbol' => '₺', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'NZD' => ['code' => 'NZD', 'title' => 'New Zealand Dollar', 'symbol' => 'NZ$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'NOK' => ['code' => 'NOK', 'title' => 'Norwegian Krone', 'symbol' => 'kr ', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'PKR' => ['code' => 'PKR', 'title' => 'Pakistan Rupee', 'symbol' => null, 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'PEN' => ['code' => 'PEN', 'title' => 'Peru, Nuevo Sol', 'symbol' => 'S/.', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'UYU' => ['code' => 'UYU', 'title' => 'Peso Uruguayo', 'symbol' => '$U ', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'PHP' => ['code' => 'PHP', 'title' => 'Philippine Peso', 'symbol' => '₱', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'PLN' => ['code' => 'PLN', 'title' => 'Poland, Zloty', 'symbol' => ' zł', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'GBP' => ['code' => 'GBP', 'title' => 'Pound Sterling', 'symbol' => '£', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'OMR' => ['code' => 'OMR', 'title' => 'Rial Omani', 'symbol' => 'OMR', 'precision' => 3, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'RON' => ['code' => 'RON', 'title' => 'Romania, New Leu', 'symbol' => null, 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'ROL' => ['code' => 'ROL', 'title' => 'Romania, Old Leu', 'symbol' => null, 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'RUB' => ['code' => 'RUB', 'title' => 'Russian Ruble', 'symbol' => ' руб', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'SAR' => ['code' => 'SAR', 'title' => 'Saudi Riyal', 'symbol' => 'SAR', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'SGD' => ['code' => 'SGD', 'title' => 'Singapore Dollar', 'symbol' => 'S$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'SKK' => ['code' => 'SKK', 'title' => 'Slovak Koruna', 'symbol' => ' SKK', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'SIT' => ['code' => 'SIT', 'title' => 'Slovenia, Tolar', 'symbol' => null, 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'ZAR' => ['code' => 'ZAR', 'title' => 'South Africa, Rand', 'symbol' => 'R', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'KRW' => ['code' => 'KRW', 'title' => 'South Korea, Won ₩', 'symbol' => '₩', 'precision' => 0, 'thousandSeparator' => ',', 'decimalSeparator' => '', 'symbolPlacement' => 'before'],
            'SZL' => ['code' => 'SZL', 'title' => 'Swaziland, Lilangeni', 'symbol' => 'E', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'SEK' => ['code' => 'SEK', 'title' => 'Swedish Krona', 'symbol' => ' kr', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'CHF' => ['code' => 'CHF', 'title' => 'Swiss Franc', 'symbol' => 'SFr ', 'precision' => 2, 'thousandSeparator' => '\'', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'TZS' => ['code' => 'TZS', 'title' => 'Tanzanian Shilling', 'symbol' => 'TSh', 'precision' => 0, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'THB' => ['code' => 'THB', 'title' => 'Thailand, Baht ฿', 'symbol' => '฿', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'TOP' => ['code' => 'TOP', 'title' => 'Tonga, Paanga', 'symbol' => 'T$ ', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'AED' => ['code' => 'AED', 'title' => 'UAE Dirham', 'symbol' => 'AED', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'UAH' => ['code' => 'UAH', 'title' => 'Ukraine, Hryvnia', 'symbol' => ' ₴', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => ',', 'symbolPlacement' => 'after'],
            'USD' => ['code' => 'USD', 'title' => 'US Dollar', 'symbol' => '$', 'precision' => 2, 'thousandSeparator' => ',', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
            'VUV' => ['code' => 'VUV', 'title' => 'Vanuatu, Vatu', 'symbol' => 'VT', 'precision' => 0, 'thousandSeparator' => ',', 'decimalSeparator' => '', 'symbolPlacement' => 'before'],
            'VEF' => ['code' => 'VEF', 'title' => 'Venezuela Bolivares Fuertes', 'symbol' => 'Bs.', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'VEB' => ['code' => 'VEB', 'title' => 'Venezuela, Bolivar', 'symbol' => 'Bs.', 'precision' => 2, 'thousandSeparator' => '.', 'decimalSeparator' => ',', 'symbolPlacement' => 'before'],
            'VND' => ['code' => 'VND', 'title' => 'Viet Nam, Dong ₫', 'symbol' => ' ₫', 'precision' => 0, 'thousandSeparator' => '.', 'decimalSeparator' => '', 'symbolPlacement' => 'after'],
            'ZWD' => ['code' => 'ZWD', 'title' => 'Zimbabwe Dollar', 'symbol' => 'Z$', 'precision' => 2, 'thousandSeparator' => ' ', 'decimalSeparator' => '.', 'symbolPlacement' => 'before'],
        ];

        return $currencies;
    }

    public static function jenisPengeluaran(){
        $jenisPengeluaran = [
            '' => 'Pilih Data',
            'dispose'   => 'Dispose',
            'penjualan' => 'Penjualan',
            'reexport'  => 'Reexport',
        ];
        return $jenisPengeluaran;
    }

    // public static function kodeDokumen(){
    //     $kodeDokumen = [
    //         ''        => 'Pilih Data Dokumen',
    //         '0407020' => 'BC 2.0',
    //         '0407632' => 'PPKEK Pengeluaran TLDDP',
    //         '0407030' => 'BC 30',
    //         '0407621' => 'PPKEK Pengeluaran Fasilitas',
    //         '0407613' => 'PPKEK Pemasukan TLDDP',
    //         '0407000' => 'Dokumen Pabean',
    //         '0407611' => 'PPKEK Pemasukan LDP',
    //         '0407631' => 'PPKEK Pengeluaran LDP',
    //         '0407027' => 'BC 2.7',
    //         '0407052' => 'FTZ 02',
    //         '0407023' => 'BC 2.3',
    //     ];
    //     return $kodeDokumen;
    // }
    public static function kodeDokumen()
    {
        return \App\Models\KodeDokumen::pluck('label', 'kode')->prepend('Pilih Data Dokumen', '');
    }
    public static function editkodeDokumen()
    {
        return \App\Models\KodeDokumen::pluck('label', 'kode')->prepend('Pilih Data Dokumen', '');
    }
    
    public static function listStatusp()
    {
        return Statusp::pluck('nama_status', 'id')->prepend('Pilih Status', '');
    }

    public static function listjenisPeng()
    {
        return JenisPeng::pluck('nama_jenis', 'id')->prepend('Pilih Jenis Pengeluaran', '');
    }
    
    public static function editlistStatusp()
    {
        return Statusp::pluck('nama_status', 'nama_status');
    }

    public static function editlistjenisPeng()
    {
        return JenisPeng::pluck('nama_jenis', 'nama_jenis');
    }

    public static function listownerr()
    {
        return Owner::pluck('nama_owner', 'nama_owner')->prepend('Pilih Owner', '');
    }

    public static function listketerangan()
    {
        return Keterangan::pluck('listketerangan', 'id')->prepend('Pilih Keterangan', '');
    }

    public static function listlokasi()
    {
        return Lokasi::pluck('namalokasi', 'namalokasi')->prepend('Pilih Lokasi', '');
    }

    public static function listdetaillokasi()
    {
        return Detaillokasi::pluck('detail_lokasi', 'detail_lokasi')->prepend('Pilih Detail Lokasi', '');
    }

    public static function editlistdetaillokasi()
    {
        return Detaillokasi::pluck('detail_lokasi', 'detail_lokasi');
    }

    public static function editlistlokasi()
    {
        return Lokasi::pluck('namalokasi', 'namalokasi');
    }

    public static function editlistketerangan()
    {
        return Keterangan::pluck('listketerangan', 'listketerangan');
    }

    public static function editlistownerr()
    {
        return Owner::pluck('nama_owner', 'nama_owner');
    }

    public static function keteranganPemasukan(){
        $keteranganPemasukan = [
            ''        => 'Pilih keterangan',
            'tidak bagus' => 'Tidak Bagus',
            'bagus' => 'Bagus',
        ];
        return $keteranganPemasukan;
    }
    public static function satuanBarang(){
        $satuanBarang = [
            ''      => 'Pilih Data Satuan',
            // 'Pcs'   => 'Pieces',
            // 'Unit'  => 'Unit',
            // 'Set'   => 'Set'
            '6'     => 'small spray',
            '8'     => 'heat lot',
            '10'    => 'group',
            '11'    => 'outfit',
            '13'    => 'ration',
            '14'    => 'shot',
            '15'    => 'stick',
            '16'    => 'hundred fifteen kg drum',
            '17'    => 'hundred lb drum',
            '18'    => 'fiftyfive gallon (US) drum',
            '19'    => 'tank truck',
            '1A'    => 'car mile',
            '1B'    => 'car count',
            '1C'    => 'locomotive count',
            '1D'    => 'caboose count',
            '1E'    => 'empty car',
            '1F'    => 'train mile',
            '1G'    => 'fuel usage gallon (US)',
            '1H'    => 'caboose mile',
            '1I'    => 'fixed rate',
            '1J'    => 'ton mile',
            '1K'    => 'locomotive mile',
            '1L'    => 'total car count',
            '1M'    => 'total car mile',
            '1X'    => 'quarter mile',
            '20'    => 'twenty foot container',
            '21'    => 'forty foot container',
            '22'    => 'decilitre per gram',
            '23'    => 'gram per cubic centimetre',
            '24'    => 'theoretical pound',
            '25'    => 'gram per square centimetre',
            '26'    => 'actual ton',
            '27'    => 'theoretical ton',
            '28'    => 'kilogram per square metre',
            '29'    => 'pound per thousand square foot',
            '2A'    => 'radian per second',
            '2B'    => 'radian per second squared',
            '2C'    => 'roentgen',
            '2G'    => 'volt AC',
            '2H'    => 'volt DC',
            '2I'    => 'British thermal unit (international table) per hou',
            '2J'    => 'cubic centimetre per second',
            '2K'    => 'cubic foot per hour',
            '2L'    => 'cubic foot per minute',
            '2M'    => 'centimetre per second',
            '2N'    => 'decibel',
            '2P'    => 'kilobyte',
            '2Q'    => 'kilobecquerel',
            '2R'    => 'kilocurie',
            '2U'    => 'megagram',
            '2V'    => 'megagram per hour',
            '2W'    => 'bin',
            '2X'    => 'metre per minute',
            '2Y'    => 'milliroentgen',
            '2Z'    => 'millivolt',
            '30'    => 'horse power day per air dry metric ton',
            '31'    => 'catch weight',
            '32'    => 'kilogram per air dry metric ton',
            '33'    => 'kilopascal square metre per gram',
            '34'    => 'kilopascal per millimetre',
            '35'    => 'millilitre per square centimetre second',
            '36'    => 'cubic foot per minute per square foot',
            '37'    => 'ounce per square foot',
            '38'    => 'ounce per square foot per 0',
            '3B'    => 'megajoule',
            '3C'    => 'manmonth',
            '3E'    => 'pound per pound of product',
            '3G'    => 'pound per piece of product',
            '3H'    => 'kilogram per kilogram of product',
            '3I'    => 'kilogram per piece of product',
            '40'    => 'millilitre per second',
            '41'    => 'millilitre per minute',
            '43'    => 'super bulk bag',
            '44'    => 'fivehundred kg bulk bag',
            '45'    => 'threehundred kg bulk bag',
            '46'    => 'fifty lb bulk bag',
            '47'    => 'fifty lb bag',
            '48'    => 'bulk car load',
            '4A'    => 'bobbin',
            '4B'    => 'cap',
            '4C'    => 'centistokes',
            '4E'    => 'twenty pack',
            '4G'    => 'microlitre',
            '4H'    => 'micrometre (micron)',
            '4K'    => 'milliampere',
            '4L'    => 'megabyte',
            '4M'    => 'milligram per hour',
            '4N'    => 'megabecquerel',
            '4O'    => 'microfarad',
            '4P'    => 'newton per metre',
            '4Q'    => 'ounce inch',
            '4R'    => 'ounce foot',
            '4T'    => 'picofarad',
            '4U'    => 'pound per hour',
            '4W'    => 'ton (US) per hour',
            '4X'    => 'kilolitre per hour',
            '53'    => 'theoretical kilogram',
            '54'    => 'theoretical tonne',
            '56'    => 'sitas',
            '57'    => 'mesh',
            '58'    => 'net kilogram',
            '59'    => 'part per million',
            '5A'    => 'barrel (US) per minute',
            '5B'    => 'batch',
            '5C'    => 'gallon(US) per thousand',
            '5E'    => 'MMSCF/day',
            '5F'    => 'pound per thousand',
            '5G'    => 'pump',
            '5H'    => 'stage',
            '5I'    => 'standard cubic foot',
            '5J'    => 'hydraulic horse power',
            '5K'    => 'count per minute',
            '5P'    => 'seismic level',
            '5Q'    => 'seismic line',
            '60'    => 'percent weight',
            '61'    => 'part per billion (US)',
            '62'    => 'percent per 1000 hour',
            '63'    => 'failure rate in time',
            '64'    => 'pound per square inch',
            '66'    => 'oersted',
            '69'    => 'test specific scale',
            '71'    => 'volt ampere per pound',
            '72'    => 'watt per pound',
            '73'    => 'ampere tum per centimetre',
            '74'    => 'millipascal',
            '76'    => 'gauss',
            '77'    => 'milli-inch',
            '78'    => 'kilogauss',
            '80'    => 'pound per square inch absolute',
            '81'    => 'henry',
            '84'    => 'kilopound-force per square inch',
            '85'    => 'foot pound-force',
            '87'    => 'pound per cubic foot',
            '89'    => 'poise',
            '90'    => 'Saybold universal second',
            '91'    => 'stokes',
            '92'    => 'calorie per cubic centimetre',
            '93'    => 'calorie per gram',
            '94'    => 'curl unit',
            '95'    => 'twenty thousand gallon (US) tankcar',
            '96'    => 'ten thousand gallon (US) tankcar',
            '97'    => 'ten kg drum',
            '98'    => 'fifteen kg drum',
            'A1'    => '15 􀳦C calorie',
            'A10'   => 'ampere square metre per joule second',
            'A11'   => 'angstrom',
            'A12'   => 'astronomical unit',
            'A13'   => 'attojoule',
            'A14'   => 'barn',
            'A15'   => 'barn per electronvolt',
            'A16'   => 'barn per steradian electronvolt',
            'A17'   => 'barn per steradian',
            'A18'   => 'becquerel per kilogram',
            'A19'   => 'becquerel per cubic metre',
            'A2'    => 'ampere per centimetre',
            '5' => 'Ganti',
            'A20'   => 'British thermal unit (international table) per sec',
            'A21'   => 'British thermal unit (international table) per pou',
            'A22'   => 'British thermal unit (international table) per sec',
            'A23'   => 'British thermal unit (international table) per hou',
            'A24'   => 'candela per square metre',
            'A25'   => 'cheval vapeur',
            'A26'   => 'coulomb metre',
            'A27'   => 'coulomb metre squared per volt',
            'A28'   => 'coulomb per cubic centimetre',
            'A29'   => 'coulomb per cubic metre',
            'A3'    => 'ampere per millimetre',
            'A30'   => 'coulomb per cubic millimetre',
            'A31'   => 'coulomb per kilogram second',
            'A32'   => 'coulomb per mole',
            'A33'   => 'coulomb per square centimetre',
            'A34'   => 'coulomb per square metre',
            'A35'   => 'coulomb per square millimetre',
            'A36'   => 'cubic centimetre per mole',
            'A37'   => 'cubic decimetre per mole',
            'A38'   => 'cubic metre per coulomb',
            'A39'   => 'cubic metre per kilogram',
            'A4'    => 'ampere per square centimetre',
            'A40'   => 'cubic metre per mole',
            'A41'   => 'ampere per square metre',
            'A42'   => 'curie per kilogram',
            'A43'   => 'deadweight tonnage',
            'A44'   => 'decalitre',
            'A45'   => 'decametre',
            'A47'   => 'decitex',
            'A48'   => 'degree Rankine',
            'A49'   => 'denier',
            'A5'    => 'ampere square metre',
            'A50'   => 'dyne second per cubic centimetre',
            'A51'   => 'dyne second per centimetre',
            'A52'   => 'dyne second per centimetre to the fifth power',
            'A53'   => 'electronvolt',
            'A54'   => 'electronvolt per metre',
            'A55'   => 'electronvolt square metre',
            'A56'   => 'electronvolt square metre per kilogram',
            'A57'   => 'erg',
            'A58'   => 'erg per centimetre',
            'A59'   => '8-part cloud cover',
            'A6'    => 'ampere per square metre kelvin squared',
            'A60'   => 'erg per cubic centimetre',
            'A61'   => 'erg per gram',
            'A62'   => 'erg per gram second',
            'A63'   => 'erg per second',
            'A64'   => 'erg per second square centimetre',
            'A65'   => 'erg per square centimetre second',
            'A66'   => 'erg square centimetre',
            'A67'   => 'erg square centimetre per gram',
            'A68'   => 'exajoule',
            'A69'   => 'farad per metre',
            'A7-'   => 'ampere per square millimetre',
            'A70'   => 'femtojoule',
            'A71'   => 'femtometre',
            'A73'   => 'foot per second squared',
            'A74'   => 'foot pound-force persecond',
            'A75'   => 'freight ton',
            'A76'   => 'gal',
            'A77'   => 'Gaussian CGS unit ofdisplacement',
            'A78'   => 'Gaussian CGS unit ofelectriccurrent',
            'A79'   => 'Gaussian CGS unit ofelectriccharge',
            'A8-'   => 'ampere second',
            'A80'   => 'Gaussian CGS unit ofelectricfield strength',
            'A81'   => 'Gaussian CGS unit ofelectricpolarization',
            'A82'   => 'Gaussian CGS unit ofelectricpotential',
            'A83'   => 'Gaussian CGS unit ofmagnetization',
            'A84'   => 'gigacoulomb per cubic metre',
            'A85'   => 'gigaelectronvolt',
            'A86'   => 'gigahertz',
            'A87'   => 'gigaohm',
            'A88'   => 'gigaohm metre',
            'A89'   => 'gigapascal',
            'A9-'   => 'rate',
            'A90'   => 'gigawatt',
            'A91'   => 'gon',
            'A93'   => 'gram per cubic metre',
            'A94'   => 'gram per mole',
            'A95'   => 'gray',
            'A96'   => 'gray per second',
            'A97'   => 'hectopascal',
            'A98'   => 'henry per metre',
            'A99'   => 'bit',
            'AA'    => 'ball',
            'AB'    => 'bulk pack',
            'ACR'   => 'Acre (4840 yd2)',
            'ACT'   => 'activity',
            'AD'    => 'byte',
            'AE'    => 'ampere per metre',
            'AH'    => 'additional minute',
            'AI'    => 'average minute per call',
            'AJ'    => 'cop',
            'AK'    => 'fathom',
            'AL'    => 'access line',
            'AM'    => 'ampoule',
            'AMH'   => 'Ampere-hour (3)',
            'AMP'   => 'Ampere',
            'ANN'   => 'Year',
            'AP'    => 'aluminium pound only',
            'APZ'   => 'Ounce GB',
            'AQ'    => 'anti-hemophilic factor (AHF) unit',
            'AR'    => 'suppository',
            'ARE'   => 'Are (100m2)',
            'AS'    => 'assortment',
            'ASM'   => 'alcoholic strength by mass',
            'ASU'   => 'alcoholic strength by volume',
            'ATM'   => 'Standard atmosphere (101325 Pa)',
            'ATT'   => 'Technical atmosphere (98066)',
            'AV'    => 'Capsule',
            'AW'    => 'Powder Filled Vial',
            'AY'    => 'assembly',
            'AZ'    => 'British thermal unit (international table) per pou',
            'B0'    => 'Btu per cubic foot',
            'B1'    => 'barrel (US) per day',
            'B10'   => 'bit per second',
            'B11'   => 'joule per kilogram kelvin',
            'B12'   => 'joule per metre',
            'B13'   => 'joule per square metre',
            'B14'   => 'joule per metre to the fourth power',
            'B15'   => 'joule per mole',
            'B16'   => 'joule per mole kelvin',
            'B17'   => 'credit',
            'B18'   => 'joule second',
            'B19'   => 'digit',
            'B2'    => 'bunk',
            'B20'   => 'joule square metre per kilogram',
            'B21'   => 'kelvin per watt',
            'B22'   => 'kiloampere',
            'B23'   => 'kiloampere per square metre',
            'B24'   => 'kiloampere per metre',
            'B25'   => 'kilobecquerel per kilogram',
            'B26'   => 'kilocoulomb',
            'B27'   => 'kilocoulomb per cubic metre',
            'B28'   => 'kilocoulomb per square metre',
            'B29'   => 'kiloelectronvolt',
            'B3'    => 'batting pound',
            'B30'   => 'gibibit',
            'B31'   => 'kilogram metre per second',
            'B32'   => 'kilogram metre squared',
            'B33'   => 'kilogram metre squared per second',
            'B34'   => 'kilogram per cubic decimetre',
            'B35'   => 'kilogram per litre',
            'B36'   => 'calorie (thermochemical) per gram',
            'B37'   => 'kilogram-force',
            'B38'   => 'kilogram-force metre',
            'B39'   => 'kilogram-force metre per second',
            'B4'    => 'barrel',
            'B40'   => 'kilogram-force per square metre',
            'B41'   => 'kilojoule per kelvin',
            'B42'   => 'kilojoule per kilogram',
            'B43'   => 'kilojoule per kilogram kelvin',
            'B44'   => 'kilojoule per mole',
            'B45'   => 'kilomole',
            'B46'   => 'kilomole per cubic metre',
            'B47'   => 'kilonewton',
            'B48'   => 'kilonewton metre',
            'B49'   => 'kiloohm',
            'B5'    => 'billet',
            'B50'   => 'kiloohm metre',
            'B51'   => 'kilopond',
            'B52'   => 'kilosecond',
            'B53'   => 'kilosiemens',
            'B54'   => 'kilosiemens per metre',
            'B55'   => 'kilovolt per metre',
            'B56'   => 'kiloweber per metre',
            'B57'   => 'light year',
            'B58'   => 'litre per mole',
            'B59'   => 'lumen hour',
            'B6'    => 'bun',
            'B60'   => 'lumen per square metre',
            'B61'   => 'lumen per watt',
            'B62'   => 'lumen second',
            'B63'   => 'lux hour',
            'B64'   => 'lux second',
            'B65'   => 'maxwell',
            'B66'   => 'megaampere per square metre',
            'B67'   => 'megabecquerel per kilogram',
            'B68'   => 'gigabit',
            'B69'   => 'megacoulomb per cubic metre',
            'B7'    => 'cycle',
            'B70'   => 'megacoulomb per square metre',
            'B71'   => 'megaelectronvolt',
            'B72'   => 'megagram per cubic metre',
            'B73'   => 'meganewton',
            'B74'   => 'meganewton metre',
            'B75'   => 'megaohm',
            'B76'   => 'megaohm metre',
            'B77'   => 'megasiemens per metre',
            'B78'   => 'megavolt',
            'B79'   => 'megavolt per metre',
            'B8'    => 'joule per cubic metre',
            'B80'   => 'gigabit per second',
            'B81'   => 'reciprocal metre squared reciprocal second',
            'B82'   => 'inch per linear foot',
            'B83'   => 'metre to the fourth power',
            'B84'   => 'microampere',
            'B85'   => 'microbar',
            'B86'   => 'microcoulomb',
            'B87'   => 'microcoulomb per cubic metre',
            'B88'   => 'microcoulomb per square metre',
            'B89'   => 'microfarad per metre',
            'B9'    => 'batt',
            'B90'   => 'microhenry',
            'B91'   => 'microhenry per metre',
            'B92'   => 'micronewton',
            'B93'   => 'micronewton metre',
            'B94'   => 'microohm',
            'B95'   => 'microohm metre',
            'B96'   => 'micropascal',
            'B97'   => 'microradian',
            'B98'   => 'microsecond',
            'B99'   => 'microsiemens',
            'BAR'   => 'Bar',
            'BB'    => 'base box',
            'BD'    => 'board',
            'BE'    => 'bundle',
            'BFT'   => 'board foot',
            'BG'    => 'bag',
            'BH'    => 'brush',
            'BHP'   => 'brake horse power',
            'BIL'   => 'Billion',
            'BJ'    => 'bucket',
            'BK'    => 'basket',
            'BL'    => 'bale',
            'BLD'   => 'Dry barrel (115)',
            'BLL'   => 'Barrel (petroleum) (458)',
            'BO'    => 'bottle',
            'BP'    => 'hundred board foot',
            'BQL'   => 'Becquerel',
            'BR'    => 'bar [unit of packaging]',
            'BT'    => 'bolt',
            'BTU'   => 'British thermal unit (international table)',
            'BUA'   => 'Bushel (35)',
            'BUI'   => 'Bushel (36)',
            'BW'    => 'base weight',
            'BX'    => 'box',
            'BZ'    => 'million BTUs',
            'C0'    => 'call',
            'C1'    => 'composite product pound (total weight)',
            'C10'   => 'millifarad',
            'C11'   => 'milligal',
            'C12'   => 'milligram per metre',
            'C13'   => 'milligray',
            'C14'   => 'millihenry',
            'C15'   => 'millijoule',
            'C16'   => 'millimetre per second',
            'C17'   => 'millimetre squared per second',
            'C18'   => 'millimole',
            'C19'   => 'mole per kilogram',
            'C2'    => 'carset',
            'C20'   => 'millinewton',
            'C21'   => 'kibibit',
            'C22'   => 'millinewton per metre',
            'C23'   => 'milliohm metre',
            'C24'   => 'millipascal second',
            'C25'   => 'milliradian',
            'C26'   => 'millisecond',
            'C27'   => 'millisiemens',
            'C28'   => 'millisievert',
            'C29'   => 'millitesla',
            'C3'    => 'microvolt per metre',
            'C30'   => 'millivolt per metre',
            'C31'   => 'milliwatt',
            'C32'   => 'milliwatt per square metre',
            'C33'   => 'milliweber',
            'C34'   => 'mole',
            'C35'   => 'mole per cubic decimetre',
            'C36'   => 'mole per cubic metre',
            'C37'   => 'kilobit',
            'C38'   => 'mole per litre',
            'C39'   => 'nanoampere',
            'C4'    => 'carload',
            'C40'   => 'nanocoulomb',
            'C41'   => 'nanofarad',
            'C42'   => 'nanofarad per metre',
            'C43'   => 'nanohenry',
            'C44'   => 'nanohenry per metre',
            'C45'   => 'nanometre',
            'C46'   => 'nanoohm metre',
            'C47'   => 'nanosecond',
            'C48'   => 'nanotesla',
            'C49'   => 'nanowatt',
            'C5'    => 'cost',
            'C50'   => 'neper',
            'C51'   => 'neper per second',
            'C52'   => 'picometre',
            'C53'   => 'newton metre second',
            'C54'   => 'newton metre squared kilogram squared',
            'C55'   => 'newton per square metre',
            'C56'   => 'newton per square millimetre',
            'C57'   => 'newton second',
            'C58'   => 'newton second per metre',
            'C59'   => 'octave',
            'C6'    => 'cell',
            'C60'   => 'ohm centimetre',
            'C61'   => 'ohm metre',
            'C62'   => 'one',
            'C63'   => 'parsec',
            'C64'   => 'pascal per kelvin',
            'C65'   => 'pascal second',
            'C66'   => 'pascal second per cubic metre',
            'C67'   => 'pascal second per metre',
            'C68'   => 'petajoule',
            'C69'   => 'phon',
            'C7'    => 'centipoise',
            'C70'   => 'picoampere',
            'C71'   => 'picocoulomb',
            'C72'   => 'picofarad per metre',
            'C73'   => 'picohenry',
            'C74'   => 'kilobit per second',
            'C75'   => 'picowatt',
            'C76'   => 'picowatt per square metre',
            'C77'   => 'pound gage',
            'C78'   => 'pound-force',
            'C79'   => 'kilovolt ampere hour',
            'C8'    => 'millicoulomb per kilogram',
            'C80'   => 'rad',
            'C81'   => 'radian',
            'C82'   => 'radian square metre per mole',
            'C83'   => 'radian square metre per kilogram',
            'C84'   => 'radian per metre',
            'C85'   => 'reciprocal angstrom',
            'C86'   => 'reciprocal cubic metre',
            'C87'   => 'reciprocal cubic metre per second',
            'C88'   => 'reciprocal electron volt per cubic metre',
            'C89'   => 'reciprocal henry',
            'C9'    => 'coil group',
            'C90'   => 'reciprocal joule per cubic metre',
            'C91'   => 'reciprocal kelvin or kelvin to the power minus one',
            'C92'   => 'reciprocal metre',
            'C93'   => 'reciprocal square metre',
            'C94'   => 'reciprocal minute',
            'C95'   => 'reciprocal mole',
            'C96'   => 'reciprocal pascal or pascal to the power minus one',
            'C97'   => 'reciprocal second',
            'C98'   => 'reciprocal second per cubic metre',
            'C99'   => 'reciprocal second per metre squared',
            'CA'    => 'can',
            'CCT'   => 'Carrying capacity in metric tonnes',
            'CDL'   => 'Candela',
            'CEL'   => 'Degree celcius',
            'CEN'   => 'Hundred',
            'CG'    => 'card',
            'CGM'   => 'centigram',
            'CH'    => 'container',
            'CJ'    => 'cone',
            'CK'    => 'connector',
            'CKG'   => 'Coulomb per kilogram',
            'CL'    => 'coil',
            'CLF'   => 'hundred leave',
            'CLT'   => 'Centilitre',
            'CMK'   => 'Square centimetre',
            'CMQ'   => 'Cubic centimetre',
            'CMT'   => 'Centimetre',
            'CNP'   => 'Hundred packs',
            'CNT'   => 'Cental GB (45',
            'CO'    => 'carboy',
            'COU'   => 'Coulomb',
            'CQ'    => 'cartridge',
            'CR'    => 'crate',
            'CS'    => 'case',
            'CT'    => 'carton',
            'CTG'   => 'content gram',
            'CTM'   => 'Metric carat (200 mg = 2.10-4 kg)',
            'CTN'   => 'content ton (metric)',
            'CU'    => 'cup',
            'CUR'   => 'Curie',
            'CV'    => 'cover',
            'CWA'   => 'Hundredweight',
            'CWI'   => 'Long/ hundredweight GB (50)',
            'CY'    => 'cylinder',
            'CZ'    => 'combo',
            'D03'   => 'kilowatt hour per hour',
            'D04'   => 'lot [unit of weight]',
            'D1'    => 'reciprocal second per steradian',
            'D10'   => 'siemens per metre',
            'D11'   => 'mebibit',
            'D12'   => 'siemens square metre per mole',
            'D13'   => 'sievert',
            'D14'   => 'thousand linear yard',
            'D15'   => 'sone',
            'D16'   => 'square centimetre per erg',
            'D17'   => 'square centimetre per steradian erg',
            'D18'   => 'metre kelvin',
            'D19'   => 'square metre kelvin per watt',
            'D2'    => 'reciprocal second per steradian metre squared',
            'D20'   => 'square metre per joule',
            'D21'   => 'square metre per kilogram',
            'D22'   => 'square metre per mole',
            'D23'   => 'pen gram (protein)',
            'D24'   => 'square metre per steradian',
            'D25'   => 'square metre per steradian joule',
            'D26'   => 'square metre per volt second',
            'D27'   => 'steradian',
            'D28'   => 'syphon',
            'D29'   => 'terahertz',
            'D30'   => 'terajoule',
            'D31'   => 'terawatt',
            'D32'   => 'terawatt hour',
            'D33'   => 'tesla',
            'D34'   => 'tex',
            'D35'   => 'calorie (thermochemical)',
            'D36'   => 'megabit',
            'D37'   => 'calorie (thermochemical) per gram kelvin',
            'D38'   => 'calorie (thermochemical) per second centimetre kel',
            'D39'   => 'calorie (thermochemical) per second square centime',
            'D40'   => 'thousand litre',
            'D41'   => 'tonne per cubic metre',
            'D42'   => 'tropical year',
            'D43'   => 'unified atomic mass unit',
            'D44'   => 'var',
            'D45'   => 'volt squared per kelvin squared',
            'D46'   => 'volt - ampere',
            'D47'   => 'volt per centimetre',
            'D48'   => 'volt per kelvin',
            'D49'   => 'millivolt per kelvin',
            'D5'    => 'kilogram per square centimetre',
            'D50'   => 'volt per metre',
            'D51'   => 'volt per millimetre',
            'D52'   => 'watt per kelvin',
            'D53'   => 'watt per metre kelvin',
            'D54'   => 'watt per square metre',
            'D55'   => 'watt per square metre kelvin',
            'D56'   => 'watt per square metre kelvin to the fourth power',
            'D57'   => 'watt per steradian',
            'D58'   => 'watt per steradian square metre',
            'D59'   => 'weber per metre',
            'D6'    => 'roentgen per second',
            'D60'   => 'weber per millimetre',
            'D61'   => 'minute [unit of angle]',
            'D62'   => 'second [unit of angle]',
            'D63'   => 'book',
            'D64'   => 'block',
            'D65'   => 'round',
            'D66'   => 'cassette',
            'D67'   => 'dollar per hour',
            'D68'   => 'number of words',
            'D69'   => 'inch to the fourth power',
            'D7'    => 'sandwich',
            'D70'   => 'International Table (IT) calorie',
            'D71'   => 'International Table (IT) calorie per second centim',
            'D72'   => 'International Table (IT) calorie per second square',
            'D73'   => 'joule square metre',
            'D74'   => 'kilogram per mole',
            'D75'   => 'calorie (international table) per gram',
            'D76'   => 'calorie (international table) per gram kelvin',
            'D77'   => 'megacoulomb',
            'D78'   => 'megajoule per second',
            'D79'   => 'beam',
            'D8'    => 'draize score',
            'D80'   => 'microwatt',
            'D81'   => 'microtesla',
            'D82'   => 'microvolt',
            'D83'   => 'millinewton metre',
            'D85'   => 'microwatt per square metre',
            'D86'   => 'millicoulomb',
            'D87'   => 'millimole per kilogram',
            'D88'   => 'millicoulomb per cubic metre',
            'D89'   => 'millicoulomb per square metre',
            'D9'    => 'dyne per square centimetre',
            'D90'   => 'cubic metre (net)',
            'D91'   => 'rem',
            'D92'   => 'band',
            'D93'   => 'second per cubic metre',
            'D94'   => 'second per cubic metre radian',
            'D95'   => 'joule per gram',
            'D96'   => 'pound gross',
            'D97'   => 'pallet/unit load',
            'D98'   => 'mass pound',
            'D99'   => 'sleeve',
            'DAA'   => 'Decare',
            'DAD'   => 'Ten day',
            'DAY'   => 'Day',
            'DB'    => 'dry pound',
            'DBC'   => 'Decade (ten years)',
            'DC'    => 'disk (disc)',
            'DD'    => 'degree [unit of angle]',
            'DE'    => 'deal',
            'DEC'   => 'decade',
            'DG'    => 'decigram',
            'DI'    => 'dispenser',
            'DJ'    => 'decagram',
            'DLT'   => 'decilitre',
            'DMA'   => 'cubic decametre',
            'DMK'   => 'Square decimetre',
            'DMO'   => 'standard kilolitre',
            'DMQ'   => 'Cubic decimetre',
            'DMT'   => 'Decimetre',
            'DN'    => 'decinewton metre',
            'DPC'   => 'dozen piece',
            'DPR'   => 'Dozen pairs',
            'DPT'   => 'Displecement tonnege',
            'DQ'    => 'data record',
            'DR'    => 'drum',
            'DRA'   => 'Dram US (3)',
            'DRI'   => 'Dram GB (1)',
            'DRL'   => 'Dozen rolls',
            'DRM'   => 'Drachm',
            'DS'    => 'display',
            'DT'    => 'dry ton',
            'DTN'   => 'Centner',
            'DU'    => 'dyne',
            'DWT'   => 'Pennyweight GB',
            'DX'    => 'dyne per centimetre',
            'DY'    => 'directory book',
            'DZN'   => 'Dozen',
            'DZP'   => 'Dozen packs',
            'E01'   => 'newton per square centimetre',
            'E07'   => 'megawatt hour per hour',
            'E08'   => 'megawatt per hertz',
            'E09'   => 'milliampere hour',
            'E10'   => 'degree day',
            'E11'   => 'gigacalorie',
            'E12'   => 'mille',
            'E14'   => 'kilocalorie (international table)',
            'E15'   => 'kilocalorie (thermochemical) per hour',
            'E16'   => 'million Btu(IT) per hour',
            'E17'   => 'cubic foot per second',
            'E18'   => 'tonne per hour',
            'E19'   => 'ping',
            'E2'    => 'belt',
            'E20'   => 'megabit per second',
            'E21'   => 'shares',
            'E22'   => 'TEU',
            'E23'   => 'tyre',
            'E25'   => 'active unit',
            'E27'   => 'dose',
            'E28'   => 'air dry ton',
            'E3'    => 'trailer',
            'E30'   => 'strand',
            'E31'   => 'square metre per litre',
            'E32'   => 'litre per hour',
            'E33'   => 'foot per thousand',
            'E34'   => 'gigabyte',
            'E35'   => 'terabyte',
            'E36'   => 'petabyte',
            'E37'   => 'pixel',
            'E38'   => 'megapixel',
            'E39'   => 'dots per inch',
            'E4'    => 'gross kilogram',
            'E40'   => 'part per hundred thousand',
            'E41'   => 'kilogram-force per square millimetre',
            'E42'   => 'kilogram-force per square centimetre',
            'E43'   => 'joule per square centimetre',
            'E44'   => 'kilogram-force metre per square centimetre',
            'E45'   => 'milliohm',
            'E46'   => 'kilowatt hour per cubic metre',
            'E47'   => 'kilowatt hour per kelvin',
            'E48'   => 'service unit',
            'E49'   => 'working day',
            'E5'    => 'metric long ton',
            'E50'   => 'accounting unit',
            'E51'   => 'job',
            'E52'   => 'run foot',
            'E53'   => 'test',
            'E54'   => 'trip',
            'E55'   => 'use',
            'E56'   => 'well',
            'E57'   => 'zone',
            'E58'   => 'exabit per second',
            'E59'   => 'exbibyte',
            'E60'   => 'pebibyte',
            'E61'   => 'tebibyte',
            'E62'   => 'gibibyte',
            'E63'   => 'mebibyte',
            'E64'   => 'kibibyte',
            'E65'   => 'exbibit per metre',
            'E66'   => 'exbibit per square metre',
            'E67'   => 'exbibit per cubic metre',
            'E68'   => 'gigabyte per second',
            'E69'   => 'gibibit per metre',
            'E70'   => 'gibibit per square metre',
            'E71'   => 'gibibit per cubic metre',
            'E72'   => 'kibibit per metre',
            'E73'   => 'kibibit per square metre',
            'E74'   => 'kibibit per cubic metre',
            'E75'   => 'mebibit per metre',
            'E76'   => 'mebibit per square metre',
            'E77'   => 'mebibit per cubic metre',
            'E78'   => 'petabit',
            'E79'   => 'petabit per second',
            'E80'   => 'pebibit per metre',
            'E81'   => 'pebibit per square metre',
            'E82'   => 'pebibit per cubic metre',
            'E83'   => 'terabit',
            'E84'   => 'terabit per second',
            'E85'   => 'tebibit per metre',
            'E86'   => 'tebibit per cubic metre',
            'E87'   => 'tebibit per square metre',
            'E88'   => 'bit per metre',
            'E89'   => 'bit per square metre',
            'E90'   => 'reciprocal centimetre',
            'E91'   => 'reciprocal day',
            'E92'   => 'cubic decimetre per hour',
            'E93'   => 'kilogram per hour',
            'E94'   => 'kilomole per second',
            'E95'   => 'mole per second',
            'E96'   => 'degree per second',
            'E97'   => 'millimetre per degree Celcius metre',
            'E98'   => 'degree celsius per kelvin',
            'E99'   => 'hektopascal per bar',
            'EA'    => 'each',
            'EB'    => 'electronic mail box',
            'EC'    => 'each per month',
            'EP'    => 'eleven pack',
            'EQ'    => 'equivalent gallon',
            'EV'    => 'envelope',
            'F01'   => 'bit per cubic metre',
            'F02'   => 'kelvin per kelvin',
            'F03'   => 'kilopascal per bar',
            'F04'   => 'millibar per bar',
            'F05'   => 'megapascal per bar',
            'F06'   => 'poise per bar',
            'F07'   => 'pascal per bar',
            'F08'   => 'milliampere per inch',
            'F1'    => 'thousand cubic foot per day',
            'F10'   => 'kelvin per hour',
            'F11'   => 'kelvin per minute',
            'F12'   => 'kelvin per second',
            'F13'   => 'slug',
            'F14'   => 'gram per kelvin',
            'F15'   => 'kilogram per kelvin',
            'F16'   => 'milligram per kelvin',
            'F17'   => 'pound-force per foot',
            'F18'   => 'kilogram square centimetre',
            'F19'   => 'kilogram square millimetre',
            'F20'   => 'pound inch squared',
            'F21'   => 'pound-force inch',
            'F22'   => 'pound-force foot per ampere',
            'F23'   => 'gram per cubic decimetre',
            'F24'   => 'kilogram per kilomol',
            'F25'   => 'gram per hertz',
            'F26'   => 'gram per day',
            'F27'   => 'gram per hour',
            'F28'   => 'gram per minute',
            'F29'   => 'gram per second',
            'F30'   => 'kilogram per day',
            'F31'   => 'kilogram per minute',
            'F32'   => 'milligram per day',
            'F33'   => 'milligram per minute',
            'F34'   => 'milligram per second',
            'F35'   => 'gram per day kelvin',
            'F36'   => 'gram per hour kelvin',
            'F37'   => 'gram per minute kelvin',
            'F38'   => 'gram per second kelvin',
            'F39'   => 'kilogram per day kelvin',
            'F40'   => 'kilogram per hour kelvin',
            'F41'   => 'kilogram per minute kelvin',
            'F42'   => 'kilogram per second kelvin',
            'F43'   => 'milligram per day kelvin',
            'F44'   => 'milligram per hour kelvin',
            'F45'   => 'milligram per minute kelvin',
            'F46'   => 'milligram per second kelvin',
            'F47'   => 'newton per millimetre',
            'F48'   => 'pound-force per inch',
            'F49'   => 'rod [unit of distance]',
            'F50'   => 'micrometre per kelvin',
            'F51'   => 'centimetre per kelvin',
            'F52'   => 'metre per kelvin',
            'F53'   => 'millimetre per kelvin',
            'F54'   => 'milliohm per metre',
            'F55'   => 'ohm per mile',
            'F56'   => 'ohm per kilometre',
            'F57'   => 'milliampere per pound-force per square inch',
            'F58'   => 'reciprocal bar',
            'F59'   => 'milliampere per bar',
            'F60'   => 'degree Celsius per bar',
            'F61'   => 'kelvin per bar',
            'F62'   => 'gram per day bar',
            'F63'   => 'gram per hour bar',
            'F64'   => 'gram per minute bar',
            'F65'   => 'gram per second bar',
            'F66'   => 'kilogram per day bar',
            'F67'   => 'kilogram per hour bar',
            'F68'   => 'kilogram per minute bar',
            'F69'   => 'kilogram per second bar',
            'F70'   => 'milligram per day bar',
            'F71'   => 'milligram per hour bar',
            'F72'   => 'milligram per minute bar',
            'F73'   => 'milligram per second bar',
            'F74'   => 'gram per bar',
            'F75'   => 'milligram per bar',
            'F76'   => 'milliampere per millimetre',
            'F77'   => 'pascal second per kelvin',
            'F78'   => 'inch of water',
            'F79'   => 'inch of mercury',
            'F80'   => 'water horse power',
            'F81'   => 'bar per kelvin',
            'F82'   => 'hektopascal per kelvin',
            'F83'   => 'kilopascal per kelvin',
            'F84'   => 'millibar per kelvin',
            'F85'   => 'megapascal per kelvin',
            'F86'   => 'poise per kelvin',
            'F87'   => 'volt per litre minute',
            'F88'   => 'newton centimetre',
            'F89'   => 'newton metre per degree',
            'F9'    => 'fibre per cubic centimetre of air',
            'F90'   => 'newton metre per ampere',
            'F91'   => 'bar litre per second',
            'F92'   => 'bar cubic metre per second',
            'F93'   => 'hektopascal litre per second',
            'F94'   => 'hektopascal cubic metre per second',
            'F95'   => 'millibar litre per second',
            'F96'   => 'millibar cubic metre per second',
            'F97'   => 'megapascal litre per second',
            'F98'   => 'megapascal cubic metre per second',
            'F99'   => 'pascal litre per second',
            'FAH'   => 'degree Fahrenheit',
            'FAR'   => 'farad',
            'FB'    => 'field',
            'FBM'   => 'fibre metre',
            'FC'    => 'thousand cubic foot',
            'FD'    => 'million particle per cubic foot',
            'FE'    => 'track foot',
            'FF'    => 'hundred cubic metre',
            'FG'    => 'transdermal patch',
            'FH'    => 'micromole',
            'FIT'   => 'failures in time',
            'FL'    => 'flake ton',
            'FM'    => 'million cubic foot',
            'FOT'   => 'Foot (0.3048 m)',
            'FP'    => 'pound per square foot',
            'FR'    => 'foot per minute',
            'FS'    => 'foot per second',
            'FTK'   => 'Square foot',
            'FTQ'   => 'Cubic foot',
            'G01'   => 'pascal cubic metre per second',
            'G04'   => 'centimetre per bar',
            'G05'   => 'metre per bar',
            'G06'   => 'millimetre per bar',
            'G08'   => 'square inch per second',
            'G09'   => 'square metre per second kelvin',
            'G10'   => 'stokes per kelvin',
            'G11'   => 'gram per cubic centimetre bar',
            'G12'   => 'gram per cubic decimetre bar',
            'G13'   => 'gram per litre bar',
            'G14'   => 'gram per cubic metre bar',
            'G15'   => 'gram per millilitre bar',
            'G16'   => 'kilogram per cubic centimetre bar',
            'G17'   => 'kilogram per litre bar',
            'G18'   => 'kilogram per cubic metre bar',
            'G19'   => 'newton metre per kilogram',
            'G2'    => 'US gallon per minute',
            'G20'   => 'pound-force foot per pound',
            'G21'   => 'cup [unit of volume]',
            'G23'   => 'peck',
            'G24'   => 'tablespoon (US)',
            'G25'   => 'teaspoon (US)',
            'G26'   => 'stere',
            'G27'   => 'cubic centimetre per kelvin',
            'G28'   => 'litre per kelvin',
            'G29'   => 'cubic metre per kelvin',
            'G3'    => 'Imperial gallon per minute',
            'G30'   => 'millilitre per kelvin',
            'G31'   => 'kilogram per cubic centimetre',
            'G32'   => 'ounce (avoirdupois) per cubic yard',
            'G33'   => 'gram per cubic centimetre kelvin',
            'G34'   => 'gram per cubic decimetre kelvin',
            'G35'   => 'gram per litre kelvin',
            'G36'   => 'gram per cubic metre kelvin',
            'G37'   => 'gram per millilitre kelvin',
            'G38'   => 'kilogram per cubic centimetre kelvin',
            'G39'   => 'kilogram per litre kelvin',
            'G40'   => 'kilogram per cubic metre kelvin',
            'G41'   => 'square metre per second bar',
            'G42'   => 'microsiemens per centimetre',
            'G43'   => 'microsiemens per metre',
            'G44'   => 'nanosiemens per centimetre',
            'G45'   => 'nanosiemens per metre',
            'G46'   => 'stokes per bar',
            'G47'   => 'cubic centimetre per day',
            'G48'   => 'cubic centimetre per hour',
            'G49'   => 'cubic centimetre per minute',
            'G50'   => 'gallon (US) per hour',
            'G51'   => 'litre per second',
            'G52'   => 'cubic metre per day',
            'G53'   => 'cubic metre per minute',
            'G54'   => 'millilitre per day',
            'G55'   => 'millilitre per hour',
            'G56'   => 'cubic inch per hour',
            'G57'   => 'cubic inch per minute',
            'G58'   => 'cubic inch per second',
            'G59'   => 'milliampere per litre minute',
            'G60'   => 'volt per bar',
            'G61'   => 'cubic centimetre per day kelvin',
            'G62'   => 'cubic centimetre per hour kelvin',
            'G63'   => 'cubic centimetre per minute kelvin',
            'G64'   => 'cubic centimetre per second kelvin',
            'G65'   => 'litre per day kelvin',
            'G66'   => 'litre per hour kelvin',
            'G67'   => 'litre per minute kelvin',
            'G68'   => 'litre per second kelvin',
            'G69'   => 'cubic metre per day kelvin',
            'G7'    => 'microfiche sheet',
            'G70'   => 'cubic metre per hour kelvin',
            'G71'   => 'cubic metre per minute kelvin',
            'G72'   => 'cubic metre per second kelvin',
            'G73'   => 'millilitre per day kelvin',
            'G74'   => 'millilitre per hour kelvin',
            'G75'   => 'millilitre per minute kelvin',
            'G76'   => 'millilitre per second kelvin',
            'G77'   => 'millimetre to the fourth power',
            'G78'   => 'cubic centimetre per day bar',
            'G79'   => 'cubic centimetre per hour bar',
            'G80'   => 'cubic centimetre per minute bar',
            'G81'   => 'cubic centimetre per second bar',
            'G82'   => 'litre per day bar',
            'G83'   => 'litre per hour bar',
            'G84'   => 'litre per minute bar',
            'G85'   => 'litre per second bar',
            'G86'   => 'cubic metre per day bar',
            'G87'   => 'cubic metre per hour bar',
            'G88'   => 'cubic metre per minute bar',
            'G89'   => 'cubic metre per second bar',
            'G90'   => 'millilitre per day bar',
            'G91'   => 'millilitre per hour bar',
            'G92'   => 'millilitre per minute bar',
            'G93'   => 'millilitre per second bar',
            'G94'   => 'cubic centimetre per bar',
            'G95'   => 'litre per bar',
            'G96'   => 'cubic metre per bar',
            'G97'   => 'millilitre per bar',
            'G98'   => 'microhenry per kiloohm',
            'G99'   => 'microhenry per ohm',
            'GB'    => 'gallon (US) per day',
            'GBQ'   => 'Gigabecquerel',
            'GC'    => 'gram per 100 gram',
            'GD'    => 'gross barrel',
            'GDW'   => 'gram',
            'GE'    => 'pound per gallon (US)',
            'GF'    => 'gram per metre (gram per 100 centimetres)',
            'GFI'   => 'gram of fissile isotope',
            'GGR'   => 'Great gross (12 gross)',
            'GH'    => 'half gallon (US)',
            'GIA'   => 'Gill (11',
            'GIC'   => 'gram',
            'GII'   => 'Gill (0',
            'GIP'   => 'gram',
            'GJ'    => 'gram per millilitre',
            'GK'    => 'gram per kilogram',
            'GL'    => 'gram per litre',
            'GLD'   => 'Dry gallon (4)',
            'GLI'   => 'Gallon (4)',
            'GLL'   => 'Liquid gallon (3)',
            'GM'    => 'gram per square metre',
            'GN'    => 'gross gallon',
            'GO'    => 'milligram per square metre',
            'GP'    => 'milligram per cubic metre',
            'GQ'    => 'microgram per cubic metre',
            'GRM'   => 'Gram',
            'GRN'   => 'Grain GB',
            'GRO'   => 'Gross',
            'GRT'   => 'Gross (register) ton',
            'GT'    => 'gross ton',
            'GV'    => 'gigajoule',
            'GW'    => 'gallon per thousand cubic foot',
            'GWH'   => 'Gigawatt-hour (1 million KW/h)',
            'GY'    => 'gross yard',
            'GZ'    => 'gage system',
            'H03'   => 'henry per kiloohm',
            'H04'   => 'henry per ohm',
            'H05'   => 'millihenry per kiloohm',
            'H06'   => 'millihenry per ohm',
            'H07'   => 'pascal second per bar',
            'H08'   => 'microbecquerel',
            'H09'   => 'reciprocal year',
            'H1'    => 'half page 􀳦 electronic',
            'H10'   => 'reciprocal hour',
            'H11'   => 'reciprocal month',
            'H12'   => 'degree Celsius per hour',
            'H13'   => 'degree Celsius per minute',
            'H14'   => 'degree Celsius per second',
            'H15'   => 'square centimetre per gram',
            'H16'   => 'square decametre',
            'H18'   => 'square hectometre',
            'H19'   => 'cubic hectometre',
            'H2'    => 'half litre',
            'H20'   => 'cubic kilometre',
            'H21'   => 'blank',
            'H22'   => 'volt square inch per pound-force',
            'H23'   => 'volt per inch',
            'H24'   => 'volt per microsecond',
            'H25'   => 'percent per kelvin',
            'H26'   => 'ohm per metre',
            'H27'   => 'degree per metre',
            'H28'   => 'microfarad per kilometre',
            'H29'   => 'microgram per litre',
            'H30'   => 'square micrometre',
            'H31'   => 'ampere per kilogram',
            'H32'   => 'ampere squared second',
            'H33'   => 'farad per kilometre',
            'H34'   => 'hertz metre',
            'H35'   => 'kelvin metre per watt',
            'H36'   => 'megaohm per kilometre',
            'H37'   => 'megaohm per metre',
            'H38'   => 'megaampere',
            'H39'   => 'megahertz kilometre',
            'H40'   => 'newton per ampere',
            'H41'   => 'newton metre watt to the power minus 0',
            'H42'   => 'pascal per metre',
            'H43'   => 'siemens per centimetre',
            'H44'   => 'teraohm',
            'H45'   => 'volt second per metre',
            'H46'   => 'volt per second',
            'H47'   => 'watt per cubic metre',
            'H48'   => 'attofarad',
            'H49'   => 'centimetre per hour',
            'H50'   => 'reciprocal cubic centimetre',
            'H51'   => 'decibel per kilometre',
            'H52'   => 'decibel per metre',
            'H53'   => 'kilogram per bar',
            'H54'   => 'kilogram per cubic decimetre kelvin',
            'H55'   => 'kilogram per cubic decimetre bar',
            'H56'   => 'kilogram per square metre second',
            'H57'   => 'inch per two pi radiant',
            'H58'   => 'metre per volt second',
            'H59'   => 'square metre per newton',
            'H60'   => 'cubic metre per cubic metre',
            'H61'   => 'millisiemens per centimetre',
            'H62'   => 'millivolt per minute',
            'H63'   => 'milligram per square centimetre',
            'H64'   => 'milligram per gram',
            'H65'   => 'millilitre per cubic metre',
            'H66'   => 'millimetre per year',
            'H67'   => 'millimetre per hour',
            'H68'   => 'millimole per gram',
            'H69'   => 'picopascal per kilometre',
            'H70'   => 'picosecond',
            'H71'   => 'percent per month',
            'H72'   => 'percent per hectobar',
            'H73'   => 'percent per decakelvin',
            'H74'   => 'watt per metre',
            'H75'   => 'decapascal',
            'H76'   => 'gram per millimetre',
            'H77'   => 'module width',
            'H78'   => 'conventional centimetre of water',
            'H79'   => 'French gauge',
            'H80'   => 'rack unit',
            'H81'   => 'millimetre per minute',
            'H82'   => 'big point',
            'H83'   => 'litre per kilogram',
            'H84'   => 'gram millimetre',
            'H85'   => 'reciprocal week',
            'H87'   => 'piece',
            'H88'   => 'megaohm kilometre',
            'H89'   => 'percent per ohm',
            'H90'   => 'percent per degree',
            'H91'   => 'percent per ten thousand',
            'H92'   => 'percent per one hundred thousand',
            'H93'   => 'percent per hundred',
            'H94'   => 'percent per thousand',
            'H95'   => 'percent per volt',
            'H96'   => 'percent per bar',
            'H98'   => 'percent per inch',
            'H99'   => 'percent per metre',
            'HA'    => 'hank',
            'HAR'   => 'Hectare',
            'HBA'   => 'Hectobar',
            'HBX'   => 'hundred boxes',
            'HC'    => 'hundred count',
            'HD'    => 'half dozen',
            'HDW'   => 'hundred kilogram',
            'HE'    => 'hundredth of a carat',
            'HF'    => 'hundred foot',
            'HGM'   => 'Hectogram',
            'HH'    => 'hundred cubic foot',
            'HI'    => 'hundred sheet',
            'HIU'   => 'Hundred intenational units',
            'HJ'    => 'metric horse power',
            'HK'    => 'hundred kilogram',
            'HKM'   => 'hundred kilogram',
            'HL'    => 'hundred foot (linear)',
            'HLT'   => 'Hectolitre',
            'HM'    => 'mile per hour',
            'HMQ'   => 'Million cubic metres',
            'HMT'   => 'Hectometre',
            'HN'    => 'conventional millimetre of mercury',
            'HO'    => 'hundred troy ounce',
            'HP'    => 'conventional millimetre of water',
            'HPA'   => 'Hectolitre of pure alcohol',
            'HS'    => 'hundred square foot',
            'HT'    => 'half hour',
            'HTZ'   => 'Hertz',
            'HUR'   => 'Hour',
            'HY'    => 'hundred yard',
            'IA'    => 'inch pound (pound inch)',
            'IC'    => 'count per inch',
            'IE'    => 'person',
            'IF'    => 'inches of water',
            'II'    => 'column inch',
            'IL'    => 'inch per minute',
            'IM'    => 'impression',
            'INH'   => 'Inch (2.54 mm)',
            'INK'   => 'Square inch',
            'INQ'   => 'Cubic inch',
            'IP'    => 'insurance policy',
            'ISD'   => 'international sugar degree',
            'IT'    => 'count per centimetre',
            'IU'    => 'inch per second',
            'IV'    => 'inch per second squared',
            'J10'   => 'percent per millimetre',
            'J12'   => 'per mille per psi',
            'J13'   => 'degree API',
            'J14'   => 'degree Baume (origin scale)',
            'J15'   => 'degree Baume (US heavy)',
            'J16'   => 'degree Baume (US light)',
            'J17'   => 'degree Balling',
            'J18'   => 'degree Brix',
            'J19'   => 'degree Fahrenheit hour square foot per British the',
            'J2'    => 'joule per kilogram',
            'J20'   => 'degree Fahrenheit per kelvin',
            'J21'   => 'degree Fahrenheit per bar',
            'J22'   => 'degree Fahrenheit hour square foot per British the',
            'J23'   => 'degree Fahrenheit per hour',
            'J24'   => 'degree Fahrenheit per minute',
            'J25'   => 'degree Fahrenheit per second',
            'J26'   => 'reciprocal degree Fahrenheit',
            'J27'   => 'degree Oechsle',
            'J28'   => 'degree Rankine per hour',
            'J29'   => 'degree Rankine per minute',
            'J30'   => 'degree Rankine per second',
            'J31'   => 'degree Twaddell',
            'J32'   => 'micropoise',
            'J33'   => 'microgram per kilogram',
            'J34'   => 'microgram per cubic metre kelvin',
            'J35'   => 'microgram per cubic metre bar',
            'J36'   => 'microlitre per litre',
            'J38'   => 'baud',
            'J39'   => 'British thermal unit (mean)',
            'J40'   => 'British thermal unit (international table) foot pe',
            'J41'   => 'British thermal unit (international table) inch pe',
            'J42'   => 'British thermal unit (international table) inch pe',
            'J43'   => 'British thermal unit (international table) per pou',
            'J44'   => 'British thermal unit (international table) per min',
            'J45'   => 'British thermal unit (international table) per sec',
            'J46'   => 'British thermal unit (thermochemical) foot per hou',
            'J47'   => 'British thermal unit (thermochemical) per hour',
            'J48'   => 'British thermal unit (thermochemical) inch per hou',
            'J49'   => 'British thermal unit (thermochemical) inch per sec',
            'J50'   => 'British thermal unit (thermochemical) per pound de',
            'J51'   => 'British thermal unit (thermochemical) per minute',
            'J52'   => 'British thermal unit (thermochemical) per second',
            'J53'   => 'coulomb square metre per kilogram',
            'J54'   => 'megabaud',
            'J55'   => 'watt second',
            'J56'   => 'bar per bar',
            'J57'   => 'barrel (UK petroleum)',
            'J58'   => 'barrel (UK petroleum) per minute',
            'J59'   => 'barrel (UK petroleum) per day',
            'J60'   => 'barrel (UK petroleum) per hour',
            'J61'   => 'barrel (UK petroleum) per second',
            'J62'   => 'barrel (US petroleum) per hour',
            'J63'   => 'barrel (US petroleum) per second',
            'J64'   => 'bushel (UK) per day',
            'J65'   => 'bushel (UK) per hour',
            'J66'   => 'bushel (UK) per minute',
            'J67'   => 'bushel (UK) per second',
            'J68'   => 'bushel (US dry) per day',
            'J69'   => 'bushel (US dry) per hour',
            'J70'   => 'bushel (US dry) per minute',
            'J71'   => 'bushel (US dry) per second',
            'J72'   => 'centinewton metre',
            'J73'   => 'centipoise per kelvin',
            'J74'   => 'centipoise per bar',
            'J75'   => 'calorie (mean)',
            'J76'   => 'calorie (international table) per gram degree Cels',
            'J78'   => 'calorie (thermochemical) per centimetre second deg',
            'J79'   => 'calorie (thermochemical) per gram degree Celsius',
            'J81'   => 'calorie (thermochemical) per minute',
            'J82'   => 'calorie (thermochemical) per second',
            'J83'   => 'clo',
            'J84'   => 'centimetre per second kelvin',
            'J85'   => 'centimetre per second bar',
            'J87'   => 'cubic centimetre per cubic metre',
            'J89'   => 'centimetre of mercury',
            'J90'   => 'cubic decimetre per day',
            'J91'   => 'cubic decimetre per cubic metre',
            'J92'   => 'cubic decimetre per minute',
            'J93'   => 'cubic decimetre per second',
            'J94'   => 'dyne centimetre',
            'J95'   => 'ounce (UK fluid) per day',
            'J96'   => 'ounce (UK fluid) per hour',
            'J97'   => 'ounce (UK fluid) per minute',
            'J98'   => 'ounce (UK fluid) per second',
            'J99'   => 'ounce (US fluid) per day',
            'JB'    => 'jumbo',
            'JE'    => 'joule per kelvin',
            'JG'    => 'jug',
            'JK'    => 'megajoule per kilogram',
            'JM'    => 'megajoule per cubic metre',
            'JNT'   => 'pipeline joint',
            'JO'    => 'joint',
            'JOU'   => 'Joule',
            'JPS'   => 'hundred metre',
            'JR'    => 'jar',
            'JWL'   => 'number of jewels',
            'K1'    => 'kilowatt demand',
            'K10'   => 'ounce (US fluid) per hour',
            'K11'   => 'ounce (US fluid) per minute',
            'K12'   => 'ounce (US fluid) per second',
            'K13'   => 'foot per degree Fahrenheit',
            'K14'   => 'foot per hour',
            'K15'   => 'foot pound-force per hour',
            'K16'   => 'foot pound-force per minute',
            'K17'   => 'foot per psi',
            'K18'   => 'foot per second degree Fahrenheit',
            'K19'   => 'foot per second psi',
            'K2'    => 'kilovolt ampere reactive demand',
            'K20'   => 'reciprocal cubic foot',
            'K21'   => 'cubic foot per degree Fahrenheit',
            'K22'   => 'cubic foot per day',
            'K23'   => 'cubic foot per psi',
            'K24'   => 'foot of water',
            'K25'   => 'foot of mercury',
            'K26'   => 'gallon (UK) per day',
            'K27'   => 'gallon (UK) per hour',
            'K28'   => 'gallon (UK) per second',
            'K3'    => 'kilovolt ampere reactive hour',
            'K30'   => 'gallon (US liquid) per second',
            'K31'   => 'gram-force per square centimetre',
            'K32'   => 'gill (UK) per day',
            'K33'   => 'gill (UK) per hour',
            'K34'   => 'gill (UK) per minute',
            'K35'   => 'gill (UK) per second',
            'K36'   => 'gill (US) per day',
            'K37'   => 'gill (US) per hour',
            'K38'   => 'gill (US) per minute',
            'K39'   => 'gill (US) per second',
            'K40'   => 'standard acceleration of free fall',
            'K41'   => 'grain per gallon (US)',
            'K42'   => 'horsepower (boiler)',
            'K43'   => 'horsepower (electric)',
            'K45'   => 'inch per degree Fahrenheit',
            'K46'   => 'inch per psi',
            'K47'   => 'inch per second degree Fahrenheit',
            'K48'   => 'inch per second psi',
            'K49'   => 'reciprocal cubic inch',
            'K5'    => 'kilovolt ampere (reactive)',
            'K50'   => 'kilobaud',
            'K51'   => 'kilocalorie (mean)',
            'K52'   => 'kilocalorie (international table) per hour metre d',
            'K53'   => 'kilocalorie (thermochemical)',
            'K54'   => 'kilocalorie (thermochemical) per minute',
            'K55'   => 'kilocalorie (thermochemical) per second',
            'K58'   => 'kilomole per hour',
            'K59'   => 'kilomole per cubic metre kelvin',
            'K6'    => 'Kilolitre',
            'K60'   => 'kilomole per cubic metre bar',
            'K61'   => 'kilomole per minute',
            'K62'   => 'litre per litre',
            'K63'   => 'reciprocal litre',
            'K64'   => 'pound (avoirdupois) per degree Fahrenheit',
            'K65'   => 'pound (avoirdupois) square foot',
            'K66'   => 'pound (avoirdupois) per day',
            'K67'   => 'pound per foot hour',
            'K68'   => 'pound per foot second',
            'K69'   => 'pound (avoirdupois) per cubic foot degree Fahrenhe',
            'K70'   => 'pound (avoirdupois) per cubic foot psi',
            'K71'   => 'pound (avoirdupois) per gallon (UK)',
            'K73'   => 'pound (avoirdupois) per hour degree Fahrenheit',
            'K74'   => 'pound (avoirdupois) per hour psi',
            'K75'   => 'pound (avoirdupois) per cubic inch degree Fahrenhe',
            'K76'   => 'pound (avoirdupois) per cubic inch psi',
            'K77'   => 'pound (avoirdupois) per psi',
            'K78'   => 'pound (avoirdupois) per minute',
            'K79'   => 'pound (avoirdupois) per minute degree Fahrenheit',
            'K80'   => 'pound (avoirdupois) per minute psi',
            'K81'   => 'pound (avoirdupois) per second',
            'K82'   => 'pound (avoirdupois) per second degree Fahrenheit',
            'K83'   => 'pound (avoirdupois) per second psi',
            'K84'   => 'pound per cubic yard',
            'K85'   => 'pound-force per square foot',
            'K86'   => 'pound-force per square inch degree Fahrenheit',
            'K87'   => 'psi cubic inch per second',
            'K88'   => 'psi litre per second',
            'K89'   => 'psi cubic metre per second',
            'K90'   => 'psi cubic yard per second',
            'K91'   => 'pound-force second per square foot',
            'K92'   => 'pound-force second per square inch',
            'K93'   => 'reciprocal psi',
            'K94'   => 'quart (UK liquid) per day',
            'K95'   => 'quart (UK liquid) per hour',
            'K96'   => 'quart (UK liquid) per minute',
            'K97'   => 'quart (UK liquid) per second',
            'K98'   => 'quart (US liquid) per day',
            'K99'   => 'quart (US liquid) per hour',
            'KA'    => 'cake',
            'KAT'   => 'katal',
            'KB'    => 'kilocharacter',
            'KBA'   => 'Kilobar',
            'KCC'   => 'kilogram of choline chloride',
            'KD'    => 'kilogram decimal',
            'KDW'   => 'kilogram drained net weight',
            'KEL'   => 'Kelvin',
            'KF'    => 'kilopacket',
            'KG'    => 'keg',
            'KGM'   => 'Kilogram',
            'KGS'   => 'kilogram per second',
            'KHY'   => 'kilogram of hydrogen peroxide',
            'KHZ'   => 'kilohertz',
            'KI'    => 'kilogram per millimetre width',
            'KIC'   => 'kilogram',
            'KIP'   => 'kilogram',
            'KJ'    => 'kilosegment',
            'KJO'   => 'Kilojoule',
            'KL'    => 'kilogram per metre',
            'KLK'   => 'lactic dry material percentage',
            'KMA'   => 'kilogram of methylamine',
            'KMH'   => 'Kilometre per hour',
            'KMK'   => 'Square kilometre',
            'KMQ'   => 'Kilogram per cubic meter',
            'KMT'   => 'Kilometre',
            'KNI'   => 'Kilogram of nitrogen',
            'KNS'   => 'Kilogram of named substance',
            'KNT'   => 'Knot ( 1 n mile oer hour',
            'KO'    => 'milliequivalence caustic potash per gram of produc',
            'KPA'   => 'kilopascal',
            'KPH'   => 'Kilogram of potassium hydroxide (caustic potasn)',
            'KPO'   => 'Kilogram of potassium oxide',
            'KPP'   => 'Kgm of phosphorus pentoxide(phosphoric anhydride',
            'KR'    => 'kiloroentgen',
            'KS'    => 'thousand pound per square inch',
            'KSD'   => 'Kilogram of substance 90 per cent dry',
            'KSH'   => 'Kilogram of sodium hydyoxide (caustic soda)',
            'KT'    => 'kit',
            'KTM'   => 'kilometre',
            'KTN'   => 'Kilotonne',
            'KUR'   => 'Kilogram of uranium',
            'KVA'   => 'Kilovolt - ampere',
            'KVR'   => 'kilovar',
            'KVT'   => 'kilovolt',
            'KW'    => 'kilogram per millimetre',
            'KWH'   => 'Kilowatt-hour',
            'KWO'   => 'kilogram of tungsten trioxide',
            'KWT'   => 'Kilowatt',
            'KX'    => 'millilitre per kilogram',
            'L10'   => 'quart (US liquid) per minute',
            'L11'   => 'quart (US liquid) per second',
            'L12'   => 'metre per second kelvin',
            'L13'   => 'metre per second bar',
            'L14'   => 'square metre hour degree Celsius per kilocalorie (',
            'L15'   => 'millipascal second per kelvin',
            'L16'   => 'millipascal second per bar',
            'L17'   => 'milligram per cubic metre kelvin',
            'L18'   => 'milligram per cubic metre bar',
            'L19'   => 'millilitre per litre',
            'L2'    => 'litre per minute',
            'L20'   => 'reciprocal cubic millimetre',
            'L21'   => 'cubic millimetre per cubic metre',
            'L23'   => 'mole per hour',
            'L24'   => 'mole per kilogram kelvin',
            'L25'   => 'mole per kilogram bar',
            'L26'   => 'mole per litre kelvin',
            'L27'   => 'mole per litre bar',
            'L28'   => 'mole per cubic metre kelvin',
            'L29'   => 'mole per cubic metre bar',
            'L30'   => 'mole per minute',
            'L31'   => 'milliroentgen aequivalent men',
            'L32'   => 'nanogram per kilogram',
            'L33'   => 'ounce (avoirdupois) per day',
            'L34'   => 'ounce (avoirdupois) per hour',
            'L35'   => 'ounce (avoirdupois) per minute',
            'L36'   => 'ounce (avoirdupois) per second',
            'L37'   => 'ounce (avoirdupois) per gallon (UK)',
            'L38'   => 'ounce (avoirdupois) per gallon (US)',
            'L39'   => 'ounce (avoirdupois) per cubic inch',
            'L40'   => 'ounce (avoirdupois)-force',
            'L41'   => 'ounce (avoirdupois)-force inch',
            'L42'   => 'pikosiemens per metre',
            'L43'   => 'peck (UK)',
            'L44'   => 'peck (UK) per day',
            'L45'   => 'peck (UK) per hour',
            'L46'   => 'peck (UK) per minute',
            'L47'   => 'peck (UK) per second',
            'L48'   => 'peck (US dry) per day',
            'L49'   => 'peck (US dry) per hour',
            'L50'   => 'peck (US dry) per minute',
            'L51'   => 'peck (US dry) per second',
            'L52'   => 'psi per psi',
            'L53'   => 'pint (UK) per day',
            'L54'   => 'pint (UK) per hour',
            'L55'   => 'pint (UK) per minute',
            'L56'   => 'pint (UK) per second',
            'L57'   => 'pint (US liquid) per day',
            'L58'   => 'pint (US liquid) per hour',
            'L59'   => 'pint (US liquid) per minute',
            'L60'   => 'pint (US liquid) per second',
            'L61'   => 'pint (US dry)',
            'L62'   => 'quart (US dry)',
            'L63'   => 'slug per day',
            'L64'   => 'slug per foot second',
            'L65'   => 'slug per cubic foot',
            'L66'   => 'slug per hour',
            'L67'   => 'slug per minute',
            'L68'   => 'slug per second',
            'L69'   => 'tonne per kelvin',
            'L70'   => 'tonne per bar',
            'L71'   => 'tonne per day',
            'L72'   => 'tonne per day kelvin',
            'L73'   => 'tonne per day bar',
            'L74'   => 'tonne per hour kelvin',
            'L75'   => 'tonne per hour bar',
            'L76'   => 'tonne per cubic metre kelvin',
            'L77'   => 'tonne per cubic metre bar',
            'L78'   => 'tonne per minute',
            'L79'   => 'tonne per minute kelvin',
            'L80'   => 'tonne per minute bar',
            'L81'   => 'tonne per second',
            'L82'   => 'tonne per second kelvin',
            'L83'   => 'tonne per second bar',
            'L84'   => 'ton (UK shipping)',
            'L85'   => 'ton long per day',
            'L86'   => 'ton (US shipping)',
            'L87'   => 'ton short per degree Fahrenheit',
            'L88'   => 'ton short per day',
            'L89'   => 'ton short per hour degree Fahrenheit',
            'L90'   => 'ton short per hour psi',
            'L91'   => 'ton short per psi',
            'L92'   => 'ton (UK long) per cubic yard',
            'L93'   => 'ton (US short) per cubic yard',
            'L94'   => 'ton-force (US short)',
            'L95'   => 'common year',
            'L96'   => 'sidereal year',
            'L98'   => 'yard per degree Fahrenheit',
            'L99'   => 'yard per psi',
            'LA'    => 'pound per cubic inch',
            'LAC'   => 'lactose excess percentage',
            'LBR'   => 'Pound GB',
            'LBT'   => 'Troy pound',
            'LC'    => 'linear centimetre',
            'LD'    => 'litre per day',
            'LE'    => 'lite',
            'LEF'   => 'leaf',
            'LF'    => 'linear foot',
            'LH'    => 'labour hour',
            'LI'    => 'linear inch',
            'LJ'    => 'large spray',
            'LK'    => 'link',
            'LM'    => 'linear metre',
            'LN'    => 'length',
            'LNT'   => 'Long ton GB',
            'LO'    => 'lot [unit of procurement]',
            'LP'    => 'liquid pound',
            'LPA'   => 'Litre of pure alcohol',
            'LR'    => 'layer',
            'LS'    => 'lump sum',
            'LTN'   => 'ton (UK) or long ton (US)',
            'LTR'   => 'Litre ( 1 dm3 )',
            'LUB'   => 'metric ton',
            'LUM'   => 'Lumen',
            'LUX'   => 'lux',
            'LX'    => 'linear yard per pound',
            'LY'    => 'linear yard',
            'M0'    => 'magnetic tape',
            'M1'    => 'milligram per litre',
            'M10'   => 'reciprocal cubic yard',
            'M11'   => 'cubic yard per degree Fahrenheit',
            'M12'   => 'cubic yard per day',
            'M13'   => 'cubic yard per hour',
            'M14'   => 'cubic yard per psi',
            'M15'   => 'cubic yard per minute',
            'M16'   => 'cubic yard per second',
            'M17'   => 'kilohertz metre',
            'M18'   => 'gigahertz metre',
            'M19'   => 'Beaufort',
            'M20'   => 'reciprocal megakelvin or megakelvin to the power m',
            'M21'   => 'reciprocal kilovolt - ampere hour',
            'M22'   => 'millilitre per square centimetre minute',
            'M23'   => 'newton per centimetre',
            'M24'   => 'ohm kilometre',
            'M25'   => 'percent per degree Celsius',
            'M26'   => 'gigaohm per metre',
            'M27'   => 'megahertz metre',
            'M29'   => 'kilogram per kilogram',
            'M30'   => 'reciprocal volt - ampere second',
            'M31'   => 'kilogram per kilometre',
            'M32'   => 'pascal second per litre',
            'M33'   => 'millimole per litre',
            'M34'   => 'newton metre per square metre',
            'M35'   => 'millivolt - ampere',
            'M36'   => '30-day month',
            'M37'   => 'actual/360',
            'M4'    => 'monetary value',
            'M5'    => 'microcurie',
            'M7'    => 'micro-inch',
            'M9'    => 'million Btu per 1000 cubic foot',
            'MA'    => 'machine per unit',
            'MAH'   => 'megavolt ampere reactive hour',
            'MAL'   => 'Megalitre',
            'MAM'   => 'Megametre',
            'MAR'   => 'megavolt ampere reactive',
            'MAW'   => 'Megawatt',
            'MBE'   => 'thousand standard brick equivalent',
            'MBF'   => 'thousand board foot',
            'MBR'   => 'millibar',
            'MC'    => 'microgram',
            'MCU'   => 'millicurie',
            'MD'    => 'air dry metric ton',
            'MF'    => 'milligram per square foot per side',
            'MGM'   => 'Milligram',
            'MHZ'   => 'megahertz',
            'MID'   => 'Thousand',
            'MIK'   => 'Square mile',
            'MIL'   => 'thousand',
            'MIN'   => 'Minute',
            'MIO'   => 'Million',
            'MIU'   => 'Million international units',
            'MK'    => 'milligram per square inch',
            'MLD'   => 'Billion US',
            'MLT'   => 'Millilitre',
            'MMK'   => 'Square millimetre',
            'MMQ'   => 'Cubic millimetre',
            'MMT'   => 'Millimetre',
            'MND'   => 'kilogram',
            'MON'   => 'Month',
            'MPA'   => 'megapascal',
            'MQ'    => 'thousand metre',
            'MQH'   => 'cubic metre per hour',
            'MQS'   => 'cubic metre per second',
            'MSK'   => 'Metre per second squared',
            'MT'    => 'mat',
            'MTK'   => 'Square metre',
            'MTQ'   => 'Cubic metre',
            'MTR'   => 'Metre',
            'MTS'   => 'metre per second',
            'MV'    => 'number of mults',
            'MVA'   => 'Megavolt - ampere (1000 KVA)',
            'MWH'   => 'Megawatt-hour (1000 KW/h)',
            'N1'    => 'pen calorie',
            'N2'    => 'number of lines',
            'N3'    => 'print point',
            'NA'    => 'milligram per kilogram',
            'NAR'   => 'Number of articles',
            'NB'    => 'barge',
            'NBB'   => 'Number bobbins',
            'NC'    => 'car',
            'NCL'   => 'number of cells',
            'ND'    => 'net barrel',
            'NE'    => 'net litre',
            'NEW'   => 'Newton',
            'NF'    => 'message',
            'NG'    => 'net gallon (us)',
            'NH'    => 'message hour',
            'NI'    => 'net imperial gallon',
            'NIL'   => 'nil',
            'NIU'   => 'Number of international units',
            'NJ'    => 'number of screens',
            'NL'    => 'load',
            'NMB'   => 'Number',
            'NMI'   => 'Nautical mile (1852 m)',
            'NMP'   => 'Number of packs',
            'NN'    => 'train',
            'NPL'   => 'Number of parcels',
            'NPR'   => 'number of pairs',
            'NPT'   => 'Number of parts',
            'NQ'    => 'mho',
            'NR'    => 'micromho',
            'NRL'   => 'Number of rolls',
            'NT'    => 'net ton',
            'NTT'   => 'Net (regirter) ton',
            'NU'    => 'newton metre',
            'NV'    => 'vehicle',
            'NX'    => 'part per thousand',
            'NY'    => 'pound per air dry metric ton',
            'OA'    => 'panel',
            'ODE'   => 'ozone depletion equivalent',
            'OHM'   => 'Ohm',
            'ON'    => 'ounce per square yard',
            'ONZ'   => 'Ounce GB',
            'OP'    => 'two pack',
            'OT'    => 'overtime hour',
            'OZ'    => 'ounce av',
            'OZA'   => 'Fluid ounce (29',
            'OZI'   => 'Fluid ounce (29',
            'P0'    => 'page - electronic',
            'P1'    => 'percent',
            'P2'    => 'pound per foot',
            'P3'    => 'three pack',
            'P4'    => 'four pack',
            'P5'    => 'five pack',
            'P6'    => 'six pack',
            'P7'    => 'seven pack',
            'P8'    => 'eight pack',
            'P9'    => 'nine pack',
            'PA'    => 'packet',
            'PAL'   => 'Pascal',
            'PB'    => 'pair inch',
            'PCE'   => 'Pieces',
            'PD'    => 'pad',
            'PE'    => 'pound equivalent',
            'PF'    => 'pallet (lift)',
            'PFL'   => 'proof litre',
            'PG'    => 'plate',
            'PGL'   => 'Proof gallon',
            'PI'    => 'pitch',
            'PK'    => 'pack',
            'PL'    => 'pail',
            'PLA'   => 'degree Plato',
            'PM'    => 'pound percentage',
            'PN'    => 'pound net',
            'PO'    => 'pound per inch of length',
            'PQ'    => 'page per inch',
            'PR'    => 'pair',
            'PS'    => 'pound-force per square inch',
            'PT'    => 'pint (US)',
            'PTD'   => 'Dry pint (0.55061 dm3)',
            'PTI'   => 'Pint (0',
            'PTL'   => 'Liquid Pint (0',
            'PU'    => 'tray / tray pack',
            'PV'    => 'half pint (US)',
            'PW'    => 'pound per inch of width',
            'PY'    => 'peck dry (US)',
            'PZ'    => 'peck dry (UK)',
            'Q3'    => 'meal',
            'QA'    => 'page - facsimile',
            'QAN'   => 'Quarter (of a year)',
            'QB'    => 'page - hardcopy',
            'QD'    => 'quarter dozen',
            'QH'    => 'quarter hour',
            'QK'    => 'quarter kilogram',
            'QR'    => 'quire',
            'QT'    => 'quart (US)',
            'QTD'   => 'Dry quart (1',
            'QTI'   => 'Quart (1',
            'QTL'   => 'Liquid quart (0',
            'QTR'   => 'Quarter GB (12',
            'R1'    => 'pica',
            'R4'    => 'calorie',
            'R9'    => 'thousand cubic metre',
            'RA'    => 'rack',
            'RD'    => 'rod',
            'RG'    => 'ring',
            'RH'    => 'running or operating hour',
            'RK'    => 'roll metric measure',
            'RL'    => 'reel',
            'RM'    => 'ream',
            'RN'    => 'ream metric measure',
            'RO'    => 'roll',
            'RP'    => 'pound per ream',
            'RPM'   => 'Revolution per minute',
            'RPS'   => 'Revolution per second',
            'RS'    => 'reset',
            'RT'    => 'revenue ton mile',
            'RU'    => 'run',
            'S3'    => 'square foot per second',
            'S4'    => 'square metre per second',
            'S5'    => 'sixty fourths of an inch',
            'S6'    => 'session',
            'S7'    => 'storage unit',
            'S8'    => 'standard advertising unit',
            'SA'    => 'sack',
            'SAN'   => 'Half year (six Months)',
            'SCO'   => 'Score',
            'SCR'   => 'Scruple GP',
            'SD'    => 'solid pound',
            'SE'    => 'section',
            'SEC'   => 'Second',
            'SET'   => 'Set',
            'SG'    => 'segment',
            'SHT'   => 'Shipping ton',
            'SIE'   => 'Siemens',
            'SK'    => 'split tank truck',
            'SL'    => 'slipsheet',
            'SMI'   => 'Statute mile (1609.344 m)',
            'SN'    => 'square rod',
            'SO'    => 'spool',
            'SP'    => 'shelf package',
            'SQ'    => 'square',
            'SQR'   => 'square',
            'SR'    => 'Strip',
            'SS'    => 'sheet metric measure',
            'SST'   => 'Short standard (7200 matches )',
            'ST'    => 'sheet',
            'STI'   => 'Stone GB (6',
            'STK'   => 'stick',
            'STL'   => 'standard litre',
            'STN'   => 'Short ton GB',
            'SV'    => 'skid',
            'SW'    => 'skein',
            'SX'    => 'shipment',
            'T0'    => 'telecommunication line in service',
            'T1'    => 'thousand pound gross',
            'T3'    => 'thousand piece',
            'T4'    => 'thousand bag',
            'T5'    => 'thousand casing',
            'T6'    => 'thousand gallon (US)',
            'T7'    => 'thousand impression',
            'T8'    => 'thousand linear inch',
            'TA'    => 'tenth cubic foot',
            'TAH'   => 'Thousand ampere-hour',
            'TC'    => 'truckload',
            'TD'    => 'therm',
            'TE'    => 'tote',
            'TF'    => 'ten square yard',
            'TI'    => 'thousand square inch',
            'TIC'   => 'metric ton',
            'TIP'   => 'metric ton',
            'TJ'    => 'thousand square centimetre',
            'TK'    => 'tank',
            'TL'    => 'thousand foot (linear)',
            'TMS'   => 'kilogram of imported meat',
            'TN'    => 'tin',
            'TNE'   => 'Metric ton (1000 kg)',
            'TP'    => 'ten pack',
            'TPR'   => 'Ten pairs',
            'TQ'    => 'thousand foot',
            'TQD'   => 'thousand cubic metres per day',
            'TR'    => 'ten square foot',
            'TRL'   => 'Trillion Eur',
            'TS'    => 'thousand square foot',
            'TSD'   => 'Tonne of subtance 90 per cent dry',
            'TSH'   => 'Ton of steam per hour',
            'TT'    => 'thousand linear metre',
            'TU'    => 'tube',
            'TV'    => 'thousand kilogram',
            'TW'    => 'thousand sheet',
            'TY'    => 'tank',
            'U1'    => 'treatment',
            'U2'    => 'Tablet',
            'UA'    => 'torr',
            'UB'    => 'telecommunication line in service average',
            'UC'    => 'telecommunication port',
            'UD'    => 'tenth minute',
            'UE'    => 'tenth hour',
            'UF'    => 'usage per telecommunication line average',
            'UH'    => 'ten thousand yard',
            'UM'    => 'million unit',
            'VA'    => 'volt - ampere per kilogram',
            'VI'    => 'vial',
            'VLT'   => 'Volt',
            'VP'    => 'percent volume',
            'VQ'    => 'bulk',
            'VS'    => 'visit',
            'W2'    => 'wet kilo',
            'W4'    => 'two week',
            'WA'    => 'watt per kilogram',
            'WB'    => 'wet pound',
            'WCD'   => 'Cord (3',
            'WE'    => 'wet ton',
            'WEB'   => 'Weber',
            'WEE'   => 'Week',
            'WG'    => 'wine gallon',
            'WH'    => 'wheel',
            'WHR'   => 'Watt-hour',
            'WI'    => 'weight per square inch',
            'WM'    => 'working month',
            'WR'    => 'wrap',
            'WSD'   => 'Standard',
            'WTT'   => 'Watt',
            'WW'    => 'millilitre of water',
            'X1'    => 'Gunter"s chain',
            'YDK'   => 'Square yard',
            'YDQ'   => 'Cubic yard',
            'YL'    => 'hundred linear yard',
            'YRD'   => 'Yard (0.9144 m)',
            'YT'    => 'ten yard',
            'Z1'    => 'lift van',
            'Z2'    => 'chest',
            'Z3'    => 'cask',
            'Z4'    => 'hogshead',
            'Z5'    => 'lug',
            'Z6'    => 'conference point',
            'Z8'    => 'newspage agate line',
            'ZP'    => 'page',
            'ZZ'    => 'mutually defined'
        ];

        return $satuanBarang;
    }
    
    public static function kategoriBarang(){
        $category = [
            ''  => 'Pilih Data Kategori',
            // 'Barang' => 'Barang',
            // 'Jasa' => 'Jasa',
            'Bahan Baku' => 'Bahan Baku',
            'Bahan Penolong' => 'Bahan Penolong',
            'Bahan Habis Pakai' => 'Bahan Habis Pakai',
            'Barang Dagangan' => 'Barang Dagangan',
            'Mesin dan Peralatan' => 'Mesin dan Peralatan',
            'Barang dalam proses' => 'Barang dalam proses',
            'Barang Jadi' => 'Barang Jadi',
            'Barang Reject & Scrapt' => 'Barang Reject & Scrapt',
            'Eletrical' => 'Eletrical',
            'Electronic' => 'Electronic',
            'Electronics' => 'Electronics',
            'Furniture & Applience' => 'Furniture & Applience',
            'Hospitality RB 18' => 'Hospitality RB 18',
            'Marshall Equipment' => 'Marshall Equipment',
            'Others' => 'Others',
            'Safety Equiptment' => 'Safety Equiptment',
            'Vehicle & Machinery' => 'Vehicle & Machinery',
        ];

        return $category;
    }

    public static $language_map =  [
        'af' => 'af-ZA', // Afrikaans
        'am' => 'am-ET', // Amharic
        'ar' => 'ar-SA', // Arabic
        'bg' => 'bg-BG', // Bulgarian
        'ca' => 'ca-ES', // Catalan
        'cs' => 'cs-CZ', // Czech
        'cy' => 'cy-GB', // Welsh
        'da' => 'da-DK', // Danish
        'de-i' => 'de-if', // German informal
        'de' => 'de-DE', // German
        'el' => 'el-GR', // Greek
        'en' => 'en-US', // English
        'et' => 'et-EE', // Estonian
        'fa' => 'fa-IR', // Persian
        'fi' => 'fi-FI', // Finnish
        'fil' => 'fil-PH', // Filipino
        'fr' => 'fr-FR', // French
        'he' => 'he-IL', // Hebrew
        'hr' => 'hr-HR', // Croatian
        'hu' => 'hu-HU', // Hungarian
        'id' => 'id-ID', // Indonesian
        'is' => 'is-IS', // Icelandic
        'it' => 'it-IT', // Italian
        'iu' => 'iu-NU', // Inuktitut
        'ja' => 'ja-JP', // Japanese
        'ko' => 'ko-KR', // Korean
        'lt' => 'lt-LT', // Lithuanian
        'lv' => 'lv-LV', // Latvian
        'mi' => 'mi-NZ', // Maori
        'mk' => 'mk-MK', // Macedonian
        'mn' => 'mn-MN', // Mongolian
        'ms' => 'ms-MY', // Malay
        'nl' => 'nl-NL', // Dutch
        'no' => 'no-NO', // Norwegian
        'pl' => 'pl-PL', // Polish
        'ro' => 'ro-RO', // Romanian
        'ru' => 'ru-RU', // Russian
        'sk' => 'sk-SK', // Slovak
        'sl' => 'sl-SI', // Slovenian
        'so' => 'so-SO', // Somali
        'ta' => 'ta-IN', // Tamil
        'th' => 'th-TH', // Thai
        'tl' => 'tl-PH', // Tagalog
        'tr' => 'tr-TR', // Turkish
        'uk' => 'uk-UA', // Ukrainian
        'vi' => 'vi-VN', // Vietnamese
        'zu' => 'zu-ZA', // Zulu
    ];

    /**
     * Simple helper to invoke the markdown parser
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.0]
     * @return string
     */
    public static function parseEscapedMarkedown($str = null)
    {
        $Parsedown = new \Parsedown();
        $Parsedown->setSafeMode(true);

        if ($str) {
            return $Parsedown->text($str);
        }
    }

    public static function parseEscapedMarkedownInline($str = null)
    {
        $Parsedown = new \Parsedown();
        $Parsedown->setSafeMode(true);

        if ($str) {
            return $Parsedown->line($str);
        }
    }

    /**
     * The importer has formatted number strings since v3,
     * so the value might be a string, or an integer.
     * If it's a number, format it as a string.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.0]
     * @return string
     */
    public static function formatCurrencyOutput($cost)
    {
        if (is_numeric($cost)) {

            if (Setting::getSettings()->digit_separator=='1.234,56') {
                return number_format($cost, 2,',', '.');
            }
            return number_format($cost, 2, '.',',');
        }
        // It's already been parsed.
        return $cost;
    }


    /**
     * Static colors for pie charts.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.3]
     * @return string
     */
    public static function defaultChartColors(int $index = 0)
    {
        if ($index < 0) {
            $index = 0;
        }

        $colors = [
            '#008941',
            '#FF4A46',
            '#006FA6',
            '#A30059',
            '#1CE6FF',
            '#FFDBE5',
            '#7A4900',
            '#0000A6',
            '#63FFAC',
            '#B79762',
            '#004D43',
            '#8FB0FF',
            '#997D87',
            '#5A0007',
            '#809693',
            '#FEFFE6',
            '#1B4400',
            '#4FC601',
            '#3B5DFF',
            '#4A3B53',
            '#FF2F80',
            '#61615A',
            '#BA0900',
            '#6B7900',
            '#00C2A0',
            '#FFAA92',
            '#FF90C9',
            '#B903AA',
            '#D16100',
            '#DDEFFF',
            '#000035',
            '#7B4F4B',
            '#A1C299',
            '#300018',
            '#0AA6D8',
            '#013349',
            '#00846F',
            '#372101',
            '#FFB500',
            '#C2FFED',
            '#A079BF',
            '#CC0744',
            '#C0B9B2',
            '#C2FF99',
            '#001E09',
            '#00489C',
            '#6F0062',
            '#0CBD66',
            '#EEC3FF',
            '#456D75',
            '#B77B68',
            '#7A87A1',
            '#788D66',
            '#885578',
            '#FAD09F',
            '#FF8A9A',
            '#D157A0',
            '#BEC459',
            '#456648',
            '#0086ED',
            '#886F4C',
            '#34362D',
            '#B4A8BD',
            '#00A6AA',
            '#452C2C',
            '#636375',
            '#A3C8C9',
            '#FF913F',
            '#938A81',
            '#575329',
            '#00FECF',
            '#B05B6F',
            '#8CD0FF',
            '#3B9700',
            '#04F757',
            '#C8A1A1',
            '#1E6E00',
            '#7900D7',
            '#A77500',
            '#6367A9',
            '#A05837',
            '#6B002C',
            '#772600',
            '#D790FF',
            '#9B9700',
            '#549E79',
            '#FFF69F',
            '#201625',
            '#72418F',
            '#BC23FF',
            '#99ADC0',
            '#3A2465',
            '#922329',
            '#5B4534',
            '#FDE8DC',
            '#404E55',
            '#0089A3',
            '#CB7E98',
            '#A4E804',
            '#324E72',
            '#6A3A4C',
            '#83AB58',
            '#001C1E',
            '#D1F7CE',
            '#004B28',
            '#C8D0F6',
            '#A3A489',
            '#806C66',
            '#222800',
            '#BF5650',
            '#E83000',
            '#66796D',
            '#DA007C',
            '#FF1A59',
            '#8ADBB4',
            '#1E0200',
            '#5B4E51',
            '#C895C5',
            '#320033',
            '#FF6832',
            '#66E1D3',
            '#CFCDAC',
            '#D0AC94',
            '#7ED379',
            '#012C58',
            '#7A7BFF',
            '#D68E01',
            '#353339',
            '#78AFA1',
            '#FEB2C6',
            '#75797C',
            '#837393',
            '#943A4D',
            '#B5F4FF',
            '#D2DCD5',
            '#9556BD',
            '#6A714A',
            '#001325',
            '#02525F',
            '#0AA3F7',
            '#E98176',
            '#DBD5DD',
            '#5EBCD1',
            '#3D4F44',
            '#7E6405',
            '#02684E',
            '#962B75',
            '#8D8546',
            '#9695C5',
            '#E773CE',
            '#D86A78',
            '#3E89BE',
            '#CA834E',
            '#518A87',
            '#5B113C',
            '#55813B',
            '#E704C4',
            '#00005F',
            '#A97399',
            '#4B8160',
            '#59738A',
            '#FF5DA7',
            '#F7C9BF',
            '#643127',
            '#513A01',
            '#6B94AA',
            '#51A058',
            '#A45B02',
            '#1D1702',
            '#E20027',
            '#E7AB63',
            '#4C6001',
            '#9C6966',
            '#64547B',
            '#97979E',
            '#006A66',
            '#391406',
            '#F4D749',
            '#0045D2',
            '#006C31',
            '#DDB6D0',
            '#7C6571',
            '#9FB2A4',
            '#00D891',
            '#15A08A',
            '#BC65E9',
            '#FFFFFE',
            '#C6DC99',
            '#203B3C',
            '#671190',
            '#6B3A64',
            '#F5E1FF',
            '#FFA0F2',
            '#CCAA35',
            '#374527',
            '#8BB400',
            '#797868',
            '#C6005A',
            '#3B000A',
            '#C86240',
            '#29607C',
            '#402334',
            '#7D5A44',
            '#CCB87C',
            '#B88183',
            '#AA5199',
            '#B5D6C3',
            '#A38469',
            '#9F94F0',
            '#A74571',
            '#B894A6',
            '#71BB8C',
            '#00B433',
            '#789EC9',
            '#6D80BA',
            '#953F00',
            '#5EFF03',
            '#E4FFFC',
            '#1BE177',
            '#BCB1E5',
            '#76912F',
            '#003109',
            '#0060CD',
            '#D20096',
            '#895563',
            '#29201D',
            '#5B3213',
            '#A76F42',
            '#89412E',
            '#1A3A2A',
            '#494B5A',
            '#A88C85',
            '#F4ABAA',
            '#A3F3AB',
            '#00C6C8',
            '#EA8B66',
            '#958A9F',
            '#BDC9D2',
            '#9FA064',
            '#BE4700',
            '#658188',
            '#83A485',
            '#453C23',
            '#47675D',
            '#3A3F00',
            '#061203',
            '#DFFB71',
            '#868E7E',
            '#98D058',
            '#6C8F7D',
            '#D7BFC2',
            '#3C3E6E',
            '#D83D66',
            '#2F5D9B',
            '#6C5E46',
            '#D25B88',
            '#5B656C',
            '#00B57F',
            '#545C46',
            '#866097',
            '#365D25',
            '#252F99',
            '#00CCFF',
            '#674E60',
            '#FC009C',
            '#92896B',
        ];

        $total_colors = count($colors);

        if ($index >= $total_colors) {

            \Log::info('Status label count is '.$index.' and exceeds the allowed count of 266.');
            //patch fix for array key overflow (color count starts at 1, array starts at 0)
            $index = $index - $total_colors - 1;

            //constraints to keep result in 0-265 range. This should never be needed, but if something happens
            //to create this many status labels and it DOES happen, this will keep it from failing at least.
            if($index < 0) {
                $index = 0;
            }
            elseif($index >($total_colors - 1)) {
                $index = $total_colors - 1;
            }
        }

        return $colors[$index];
    }

    /**
     * Increases or decreases the brightness of a color by a percentage of the current brightness.
     *
     * @param   string  $hexCode        Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
     * @param   float   $adjustPercent  A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
     *
     * @return  string
     */
    public static function adjustBrightness($hexCode, $adjustPercent)
    {
        $hexCode = ltrim($hexCode, '#');

        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0].$hexCode[0].$hexCode[1].$hexCode[1].$hexCode[2].$hexCode[2];
        }

        $hexCode = array_map('hexdec', str_split($hexCode, 2));

        foreach ($hexCode as &$color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustPercent);

            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }

        return '#'.implode($hexCode);
    }

    /**
     * Static background (highlight) colors for pie charts
     * This is inelegant, and could be refactored later.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.2]
     * @return array
     */
    public static function chartBackgroundColors()
    {
        $colors = [
            '#f56954',
            '#00a65a',
            '#f39c12',
            '#00c0ef',
            '#3c8dbc',
            '#d2d6de',
            '#3c8dbc',
            '#3c8dbc',
            '#3c8dbc',

        ];

        return $colors;
    }


    /**
     * Format currency using comma for thousands until local info is property used.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.7]
     * @return string
     */
    public static function ParseFloat($floatString)
    {
        /*******
         * 
         * WARNING: This does conversions based on *locale* - a Unix-ey-like thing.
         * 
         * Everything else in the system tends to convert based on the Snipe-IT settings
         * 
         * So it's very likely this is *not* what you want - instead look for the new
         * 
         * ParseCurrency($currencyString)
         * 
         * Which should be directly below here
         * 
         */
        $LocaleInfo = localeconv();
        $floatString = str_replace(',', '', $floatString);
        $floatString = str_replace($LocaleInfo['decimal_point'], '.', $floatString);
        // Strip Currency symbol
        // If no currency symbol is set, default to $ because Murica
        $currencySymbol = $LocaleInfo['currency_symbol'];
        if (empty($currencySymbol)) {
            $currencySymbol = '$';
        }

        $floatString = str_replace($currencySymbol, '', $floatString);

        return floatval($floatString);
    }
    
    /**
     * Format currency using comma or period for thousands, and period or comma for decimal, based on settings.
     * 
     * @author [B. Wetherington] [<bwetherington@grokability.com>]
     * @since [v5.2]
     * @return Float
     */
    public static function ParseCurrency($currencyString) {
        $without_currency = str_replace(Setting::getSettings()->default_currency, '', $currencyString); //generally shouldn't come up, since we don't do this in fields, but just in case it does...
        if(Setting::getSettings()->digit_separator=='1.234,56') {
            //EU format
            $without_thousands = str_replace('.', '', $without_currency);
            $corrected_decimal = str_replace(',', '.', $without_thousands);
        } else {
            $without_thousands = str_replace(',', '', $without_currency);
            $corrected_decimal = $without_thousands;  // decimal is already OK
        }
        return floatval($corrected_decimal);
    }

    /**
     * Get the list of status labels in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function statusLabelList()
    {
        $statuslabel_list = ['' => trans('general.select_statuslabel')] + Statuslabel::orderBy('default_label', 'desc')->orderBy('name', 'asc')->orderBy('deployable', 'desc')
                ->pluck('name', 'id')->toArray();

        return $statuslabel_list;
    }

    /**
     * Get the list of deployable status labels in an array to make a dropdown menu
     *
     * @todo This should probably be a selectlist, same as the other endpoints
     * and we should probably add to the API controllers to make sure that
     * the status_id submitted is actually really deployable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.1.0]
     * @return array
     */
    public static function deployableStatusLabelList()
    {
        $statuslabel_list = Statuslabel::where('deployable', '=', '1')->orderBy('default_label', 'desc')
                ->orderBy('name', 'asc')
                ->orderBy('deployable', 'desc')
                ->pluck('name', 'id')->toArray();

        return $statuslabel_list;
    }

    /**
     * Get the list of status label types in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function statusTypeList()
    {
        $statuslabel_types =
              ['' => trans('admin/hardware/form.select_statustype')]
            + ['deployable' => trans('admin/hardware/general.deployable')]
            + ['pending' => trans('admin/hardware/general.pending')]
            + ['undeployable' => trans('admin/hardware/general.undeployable')]
            + ['archived' => trans('admin/hardware/general.archived')];

        return $statuslabel_types;
    }

    /**
     * Get the list of depreciations in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function depreciationList()
    {
        $depreciation_list = ['' => 'Do Not Depreciate'] + Depreciation::orderBy('name', 'asc')
                ->pluck('name', 'id')->toArray();

        return $depreciation_list;
    }

    /**
     * Get the list of category types in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function categoryTypeList($selection=null)
    {
        $category_types = [
            '' => '',
            'accessory' => trans('general.accessory'),
            'asset' => trans('general.asset'),
            'consumable' => trans('general.consumable'),
            'component' => trans('general.component'),
            'license' => trans('general.license'),
        ];

        if ($selection != null){
            return $category_types[strtolower($selection)];
        }
        else
        return $category_types;
    }
    /**
     * Get the list of custom fields in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.5]
     * @return array
     */
    public static function customFieldsetList()
    {
        $customfields = ['' => trans('admin/models/general.no_custom_field')] + CustomFieldset::pluck('name', 'id')->toArray();

        return  $customfields;
    }

    /**
     * Get the list of custom field formats in an array to make a dropdown menu
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.4]
     * @return array
     */
    public static function predefined_formats()
    {
        $keys = array_keys(CustomField::PREDEFINED_FORMATS);
        $stuff = array_combine($keys, $keys);

        return $stuff;
    }

    /**
     * Get the list of barcode dimensions
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.3]
     * @return array
     */
    public static function barcodeDimensions($barcode_type = 'QRCODE')
    {
        if ($barcode_type == 'C128') {
            $size['height'] = '-1';
            $size['width'] = '-10';
        } elseif ($barcode_type == 'PDF417') {
            $size['height'] = '-3';
            $size['width'] = '-10';
        } else {
            $size['height'] = '-3';
            $size['width'] = '-3';
        }

        return $size;
    }

    /**
     * Generates a random string
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return array
     */
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * This nasty little method gets the low inventory info for the
     * alert dropdown
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return array
     */
    public static function checkLowInventory()
    {
        $consumables = Consumable::withCount('consumableAssignments as consumable_assignments_count')->whereNotNull('min_amt')->get();
        $accessories = Accessory::withCount('users as users_count')->whereNotNull('min_amt')->get();
        $components = Component::whereNotNull('min_amt')->get();
        $asset_models = AssetModel::where('min_amt', '>', 0)->get();

        $avail_consumables = 0;
        $items_array = [];
        $all_count = 0;

        foreach ($consumables as $consumable) {
            $avail = $consumable->numRemaining();
            if ($avail < ($consumable->min_amt) + \App\Models\Setting::getSettings()->alert_threshold) {
                if ($consumable->qty > 0) {
                    $percent = number_format((($avail / $consumable->qty) * 100), 0);
                } else {
                    $percent = 100;
                }

                $items_array[$all_count]['id'] = $consumable->id;
                $items_array[$all_count]['name'] = $consumable->name;
                $items_array[$all_count]['type'] = 'consumables';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining'] = $avail;
                $items_array[$all_count]['min_amt'] = $consumable->min_amt;
                $all_count++;
            }
        }

        foreach ($accessories as $accessory) {
            $avail = $accessory->qty - $accessory->users_count;
            if ($avail < ($accessory->min_amt) + \App\Models\Setting::getSettings()->alert_threshold) {
                if ($accessory->qty > 0) {
                    $percent = number_format((($avail / $accessory->qty) * 100), 0);
                } else {
                    $percent = 100;
                }

                $items_array[$all_count]['id'] = $accessory->id;
                $items_array[$all_count]['name'] = $accessory->name;
                $items_array[$all_count]['type'] = 'accessories';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining'] = $avail;
                $items_array[$all_count]['min_amt'] = $accessory->min_amt;
                $all_count++;
            }
        }

        foreach ($components as $component) {
            $avail = $component->numRemaining();
            if ($avail < ($component->min_amt) + \App\Models\Setting::getSettings()->alert_threshold) {
                if ($component->qty > 0) {
                    $percent = number_format((($avail / $component->qty) * 100), 0);
                } else {
                    $percent = 100;
                }

                $items_array[$all_count]['id'] = $component->id;
                $items_array[$all_count]['name'] = $component->name;
                $items_array[$all_count]['type'] = 'components';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining'] = $avail;
                $items_array[$all_count]['min_amt'] = $component->min_amt;
                $all_count++;
            }
        }

        foreach ($asset_models as $asset_model){

            $asset = new Asset();
            $total_owned = $asset->where('model_id', '=', $asset_model->id)->count();
            $avail = $asset->where('model_id', '=', $asset_model->id)->whereNull('assigned_to')->count();

            if ($avail < ($asset_model->min_amt)+ \App\Models\Setting::getSettings()->alert_threshold) {
                if ($avail > 0) {
                    $percent = number_format((($avail / $total_owned) * 100), 0);
                } else {
                    $percent = 100;
                }
                $items_array[$all_count]['id'] = $asset_model->id;
                $items_array[$all_count]['name'] = $asset_model->name;
                $items_array[$all_count]['type'] = 'models';
                $items_array[$all_count]['percent'] = $percent;
                $items_array[$all_count]['remaining'] = $avail;
                $items_array[$all_count]['min_amt'] = $asset_model->min_amt;
                $all_count++;
            }
        }

        return $items_array;
    }

    /**
     * Check if the file is an image, so we can show a preview
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param File $file
     * @return string | Boolean
     */
    public static function checkUploadIsImage($file)
    {
        $finfo = @finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $filetype = @finfo_file($finfo, $file);
        finfo_close($finfo);

        if (($filetype == 'image/jpeg') || ($filetype == 'image/jpg') || ($filetype == 'image/png') || ($filetype == 'image/bmp') || ($filetype == 'image/gif')) {
            return $filetype;
        }

        return false;
    }

    /**
     * Walks through the permissions in the permissions config file and determines if
     * permissions are granted based on a $selected_arr array.
     *
     * The $permissions array is a multidimensional array broke down by section.
     * (Licenses, Assets, etc)
     *
     * The $selected_arr should be a flattened array that contains just the
     * corresponding permission name and a true or false boolean to determine
     * if that group/user has been granted that permission.
     *
     * @author [A. Gianotto] [<snipe@snipe.net]
     * @param array $permissions
     * @param array $selected_arr
     * @since [v1.0]
     * @return array
     */
    public static function selectedPermissionsArray($permissions, $selected_arr = [])
    {
        $permissions_arr = [];

        foreach ($permissions as $permission) {
            for ($x = 0; $x < count($permission); $x++) {
                $permission_name = $permission[$x]['permission'];

                if ($permission[$x]['display'] === true) {
                    if ($selected_arr) {
                        if (array_key_exists($permission_name, $selected_arr)) {
                            $permissions_arr[$permission_name] = $selected_arr[$permission_name];
                        } else {
                            $permissions_arr[$permission_name] = '0';
                        }
                    } else {
                        $permissions_arr[$permission_name] = '0';
                    }
                }
            }
        }

        return $permissions_arr;
    }

    /**
     * Introspects into the model validation to see if the field passed is required.
     * This is used by the blades to add a required class onto the HTML element.
     * This isn't critical, but is helpful to keep form fields in sync with the actual
     * model level validation.
     *
     * This does not currently handle form request validation requiredness :(
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return bool
     */
    public static function checkIfRequired($class, $field)
    {
        $rules = $class::rules();
        foreach ($rules as $rule_name => $rule) {
            if ($rule_name == $field) {
                if (strpos($rule, 'required') === false) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    /**
     * Check to see if the given key exists in the array, and trim excess white space before returning it
     *
     * @author Daniel Melzter
     * @since 3.0
     * @param $array array
     * @param $key string
     * @param $default string
     * @return string
     */
    public static function array_smart_fetch(array $array, $key, $default = '')
    {
        array_change_key_case($array, CASE_LOWER);

        return array_key_exists(strtolower($key), array_change_key_case($array)) ? e(trim($array[$key])) : $default;
    }

    /**
     * Gracefully handle decrypting encrypted fields (custom fields, etc).
     *
     * @todo allow this to handle more than just strings (arrays, etc)
     *
     * @author A. Gianotto
     * @since 3.6
     * @param CustomField $field
     * @param string $string
     * @return string
     */
    public static function gracefulDecrypt(CustomField $field, $string)
    {
        if ($field->isFieldDecryptable($string)) {
            try {
                Crypt::decrypt($string);

                return Crypt::decrypt($string);
            } catch (DecryptException $e) {
                return 'Error Decrypting: '.$e->getMessage();
            }
            }

        return $string;
    }
    public static function formatStandardApiResponse($status, $payload = null, $messages = null)

    {
        $array['status'] = $status;
        $array['messages'] = $messages;
        if (($messages) && (is_array($messages)) && (count($messages) > 0)) {
            $array['messages'] = $messages;
        }
        ($payload) ? $array['payload'] = $payload : $array['payload'] = null;

        return $array;
    }

    /*
    Possible solution for unicode fieldnames
    */
    public static function make_slug($string)
    {
        return preg_replace('/\s+/u', '_', trim($string));
    }

    /**
     * Return an array (or null) of the the raw and formatted date object for easy use in
     * the API and the bootstrap table listings.
     *
     * @param $date
     * @param $type
     * @param $array
     * @return array|string|null
     */

    public static function getFormattedDateObject($date, $type = 'datetime', $array = true)
    {
        if ($date == '') {
            return null;
        }

        $settings = Setting::getSettings();

        /**
         * Wrap this in a try/catch so that if Carbon crashes, for example if the $date value
         * isn't actually valid, we don't crash out completely.
         *
         * While this *shouldn't* typically happen since we validate dates before entering them
         * into the database (and we use date/datetime fields for native fields in the system),
         * it is a possible scenario that a custom field could be created as an "ANY" field, data gets
         * added, and then the custom field format gets edited later. If someone put bad data in the
         * database before then - or if they manually edited the field's value - it will crash.
         *
         */


        try {
            $tmp_date = new \Carbon($date);

            if ($type == 'datetime') {
                $dt['datetime'] = $tmp_date->format('Y-m-d H:i:s');
                $dt['formatted'] = $tmp_date->format($settings->date_display_format.' '.$settings->time_display_format);
            } else {
                $dt['date'] = $tmp_date->format('Y-m-d');
                $dt['formatted'] = $tmp_date->format($settings->date_display_format);
            }

            if ($array == 'true') {
                return $dt;
            }

            return $dt['formatted'];

        } catch (\Exception $e) {
            \Log::warning($e);
            return $date.' (Invalid '.$type.' value.)';
        }

    }

    // Nicked from Drupal :)
    // Returns a file size limit in bytes based on the PHP upload_max_filesize
    // and post_max_size
    public static function file_upload_max_size()
    {
        static $max_size = -1;

        if ($max_size < 0) {

            // Start with post_max_size.
            $post_max_size = self::parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = $post_max_size;
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }

        return $max_size;
    }

    public static function file_upload_max_size_readable()
    {
        static $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $post_max_size = self::parse_size(ini_get('post_max_size'));
            if ($post_max_size > 0) {
                $max_size = ini_get('post_max_size');
            }

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = self::parse_size(ini_get('upload_max_filesize'));

            if ($upload_max > 0 && $upload_max < $post_max_size) {
                $max_size = ini_get('upload_max_filesize');
            }
        }

        return $max_size;
    }

    public static function parse_size($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }

    public static function filetype_icon($filename)
    {
        $extension = substr(strrchr($filename, '.'), 1);

        $allowedExtensionMap = [
            // Images
            'jpg'   => 'far fa-image',
            'jpeg'   => 'far fa-image',
            'gif'   => 'far fa-image',
            'png'   => 'far fa-image',
            // word
            'doc'   => 'far fa-file-word',
            'docx'   => 'far fa-file-word',
            // Excel
            'xls'   => 'far fa-file-excel',
            'xlsx'   => 'far fa-file-excel',
            // archive
            'zip'   => 'fas fa-file-archive',
            'rar'   => 'fas fa-file-archive',
            //Text
            'txt'   => 'far fa-file-alt',
            'rtf'   => 'far fa-file-alt',
            'xml'   => 'far fa-file-alt',
            // Misc
            'pdf'   => 'far fa-file-pdf',
            'lic'   => 'far fa-save',
        ];

        if ($extension && array_key_exists($extension, $allowedExtensionMap)) {
            return $allowedExtensionMap[$extension];
        }

        return 'far fa-file';
    }

    public static function show_file_inline($filename)
    {
        $extension = substr(strrchr($filename, '.'), 1);

        if ($extension) {
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                case 'gif':
                case 'png':
                    return true;
                    break;
                default:
                    return false;
            }
        }

        return false;
    }

    /**
     * Generate a random encrypted password.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return string
     */
    public static function generateEncyrptedPassword(): string
    {
        return bcrypt(self::generateUnencryptedPassword());
    }

    /**
     * Get a random unencrypted password.
     *
     * @author Steffen Buehl <sb@sbuehl.com>
     *
     * @since 5.0.0
     *
     * @return string
     */
    public static function generateUnencryptedPassword(): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $password = '';
        for ($i = 0; $i < 20; $i++) {
            $password .= substr($chars, random_int(0, strlen($chars) - 1), 1);
        }

        return $password;
    }

    /**
     * Process base64 encoded image data and save it on supplied path
     *
     * @param string $image_data base64 encoded image data with mime type
     * @param string $save_path path to a folder where the image should be saved
     * @return string path to uploaded image or false if something went wrong
     */
    public static function processUploadedImage(String $image_data, String $save_path)
    {
        if ($image_data == null || $save_path == null) {
            return false;
        }

        // After modification, the image is prefixed by mime info like the following:
        // data:image/jpeg;base64,; This causes the image library to be unhappy, so we need to remove it.
        $header = explode(';', $image_data, 2)[0];
        // Grab the image type from the header while we're at it.
        $extension = substr($header, strpos($header, '/') + 1);
        // Start reading the image after the first comma, postceding the base64.
        $image = substr($image_data, strpos($image_data,',') + 1);

        $file_name = str_random(25).'.'.$extension;

        $directory = public_path($save_path);
        // Check if the uploads directory exists.  If not, try to create it.
        if (! file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = public_path($save_path.$file_name);

        try {
            Image::make($image)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
        } catch (\Exception $e) {
            return false;
        }

        return $file_name;
    }


    /**
     * Universal helper to show file size in human-readable formats
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since 5.0
     *
     * @return string[]
     */
    public static function formatFilesizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    /**
     * This is weird but used by the side nav to determine which URL to point the user to
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since 5.0
     *
     * @return string[]
     */
    public static function SettingUrls(){
        $settings=['#','fields.index', 'statuslabels.index', 'models.index', 'categories.index', 'manufacturers.index', 'suppliers.index', 'departments.index', 'locations.index', 'companies.index', 'depreciations.index'];

        return $settings;
        }


    /**
     * Generic helper (largely used by livewire right now) that returns the font-awesome icon
     * for the object type.
     *
     * @author A. Gianotto <snipe@snipe.net>
     * @since 6.1.0
     *
     * @return string
     */
    public static function iconTypeByItem($item) {

        switch ($item) {
            case 'asset':
                return 'fas fa-barcode';
                break;
            case 'accessory':
                return 'fas fa-keyboard';
                break;
            case 'component':
                return 'fas fa-hdd';
                break;
            case 'consumable':
                return 'fas fa-tint';
                break;
            case 'license':
                return 'far fa-save';
                break;
            case 'location':
                return 'fas fa-map-marker-alt';
                break;
            case 'user':
                return 'fas fa-user';
                break;
        }

    }


     /*
     * This is a shorter way to see if the app is in demo mode.
     *
     * This makes it cleanly available in blades and in controllers, e.g.
     *
     * Blade:
     * {{ Helper::isDemoMode() ? ' disabled' : ''}} for form blades where we need to disable a form
     *
     * Controller:
     * if (Helper::isDemoMode()) {
     *      // don't allow the thing
     * }
     * @todo - use this everywhere else in the app where we have very long if/else config('app.lock_passwords') stuff
     */
    public static function isDemoMode() {
        if (config('app.lock_passwords') === true) {
            return true;
            \Log::debug('app locked!');
        }
        
        return false;
    }

  
    /**
     * Conversion between units of measurement
     *
     * @author Grant Le Roux <grant.leroux+snipe-it@gmail.com>
     * @since 5.0
     * @param float  $value    Measurement value to convert
     * @param string $srcUnit  Source unit of measurement
     * @param string $dstUnit  Destination unit of measurement
     * @param int    $round    Round the result to decimals (Default false - No rounding)
     * @return float
     */
    public static function convertUnit($value, $srcUnit, $dstUnit, $round=false) {
        $srcFactor = static::getUnitConversionFactor($srcUnit);
        $dstFactor = static::getUnitConversionFactor($dstUnit);
        $output = $value * $srcFactor / $dstFactor;
        return ($round !== false) ? round($output, $round) : $output;
    }
  
    /**
     * Get conversion factor from unit of measurement to mm
     *
     * @author Grant Le Roux <grant.leroux+snipe-it@gmail.com>
     * @since 5.0
     * @param string $unit  Unit of measurement
     * @return float
     */
    public static function getUnitConversionFactor($unit) {
        switch (strtolower($unit)) {
            case 'mm':
                return 1.0;
            case 'cm':
                return 10.0;
            case 'm':
                return 1000.0;
            case 'in':
                return 25.4;
            case 'ft':
                return 12 * static::getUnitConversionFactor('in');
            case 'yd':
                return 3 * static::getUnitConversionFactor('ft');
            case 'pt':
                return (1 / 72) * static::getUnitConversionFactor('in');
            default:
                throw new \InvalidArgumentException('Unit: \'' . $unit . '\' is not supported');

                return false;
        }
    }


    /*
     * I know it's gauche to return a shitty HTML string, but this is just a helper and since it will be the same every single time,
     * it seemed pretty safe to do here. Don't you judge me.
     */
    public static function showDemoModeFieldWarning() {
        if (Helper::isDemoMode()) {
            return "<p class=\"text-warning\"><i class=\"fas fa-lock\"></i>" . trans('general.feature_disabled') . "</p>";
        }
    }


    /**
     * Ah, legacy code.
     *
     * This corrects the original mistakes from 2013 where we used the wrong locale codes. Hopefully we
     * can get rid of this in a future version, but this should at least give us the belt and suspenders we need
     * to be sure this change is not too disruptive.
     *
     * In this array, we ONLY include the older languages where we weren't using the correct locale codes.
     *
     * @see public static $language_map in this file
     * @author A. Gianotto <snipe@snipe.net>
     * @since 6.3.0
     *
     * @param $language_code
     * @return string []
     */
    public static function mapLegacyLocale($language_code = null)
    {

        if (strlen($language_code) > 4) {
            return $language_code;
        }

        foreach (self::$language_map as $legacy => $new) {
            if ($language_code == $legacy) {
                \Log::debug('Current language is '.$legacy.', using '.$new.' instead');
                return $new;
            }
        }

        // Return US english if we don't have a match
        return 'en-US';
    }

    public static function mapBackToLegacyLocale($new_locale = null)
    {
        if (strlen($new_locale) <= 4) {
            return $new_locale; //"new locale" apparently wasn't quite so new
        }

        // This does a *reverse* search against our new language map array - given the value, find the *key* for it
        $legacy_locale = array_search($new_locale, self::$language_map);

        if($legacy_locale !== false) {
            return $legacy_locale;
        }
        return $new_locale; // better that you have some weird locale that doesn't fit into our mappings anywhere than 'void'
    }

}
