<?php

namespace Derhub\Shared\Utils;

class CountryLookup
{
    public const KEY_ALPHA2 = 'alpha2';
    public const KEY_ALPHA3 = 'alpha3';
    public const KEY_NUMERIC = 'numeric';
    public const KEY_CURRENCY = 'currency';
    public const KEY_NAME = 'name';

    /**
     * Override country data set
     * @param array $countries
     */
    public static function setCountries(array $countries): void
    {
        self::$countries = $countries;
    }

    public static function isValidKey(string $key): bool
    {
        return isset(self::$countries[$key]);
    }

    public static function fromAlpha2($value): array
    {
        if (! self::isValidKey($value)) {
            throw InvalidCountryException::fromKey($value);
        }

        return self::$countries[$value];
    }

    public static function values(): array
    {
        return self::$countries;
    }

    public static function keys(): array
    {
        return self::$alpha2Values;
    }

    private static array $alpha2Values = [];

    private static array $countries = [
        'AF' => [
            'name' => 'Afghanistan',
            'alpha2' => 'AF',
            'alpha3' => 'AFG',
            'numeric' => '004',
            'currency' => ['AFN'],
        ],

        'AX' => [
            'name' => 'Åland Islands',
            'alpha2' => 'AX',
            'alpha3' => 'ALA',
            'numeric' => '248',
            'currency' => ['EUR'],
        ],

        'AL' => [
            'name' => 'Albania',
            'alpha2' => 'AL',
            'alpha3' => 'ALB',
            'numeric' => '008',
            'currency' => ['ALL'],
        ],

        'DZ' => [
            'name' => 'Algeria',
            'alpha2' => 'DZ',
            'alpha3' => 'DZA',
            'numeric' => '012',
            'currency' => ['DZD'],
        ],

        'AS' => [
            'name' => 'American Samoa',
            'alpha2' => 'AS',
            'alpha3' => 'ASM',
            'numeric' => '016',
            'currency' => ['USD'],
        ],

        'AD' => [
            'name' => 'Andorra',
            'alpha2' => 'AD',
            'alpha3' => 'AND',
            'numeric' => '020',
            'currency' => ['EUR'],
        ],

        'AO' => [
            'name' => 'Angola',
            'alpha2' => 'AO',
            'alpha3' => 'AGO',
            'numeric' => '024',
            'currency' => ['AOA'],
        ],

        'AI' => [
            'name' => 'Anguilla',
            'alpha2' => 'AI',
            'alpha3' => 'AIA',
            'numeric' => '660',
            'currency' => ['XCD'],
        ],

        'AQ' => [
            'name' => 'Antarctica',
            'alpha2' => 'AQ',
            'alpha3' => 'ATA',
            'numeric' => '010',
            'currency' => [
                'ARS',
                'AUD',
                'BGN',
                'BRL',
                'BYR',
                'CLP',
                'CNY',
                'CZK',
                'EUR',
                'GBP',
                'INR',
                'JPY',
                'KRW',
                'NOK',
                'NZD',
                'PEN',
                'PKR',
                'PLN',
                'RON',
                'RUB',
                'SEK',
                'UAH',
                'USD',
                'UYU',
                'ZAR',
            ],
        ],

        'AG' => [
            'name' => 'Antigua and Barbuda',
            'alpha2' => 'AG',
            'alpha3' => 'ATG',
            'numeric' => '028',
            'currency' => ['XCD'],
        ],

        'AR' => [
            'name' => 'Argentina',
            'alpha2' => 'AR',
            'alpha3' => 'ARG',
            'numeric' => '032',
            'currency' => ['ARS'],
        ],

        'AM' => [
            'name' => 'Armenia',
            'alpha2' => 'AM',
            'alpha3' => 'ARM',
            'numeric' => '051',
            'currency' => ['AMD'],
        ],

        'AW' => [
            'name' => 'Aruba',
            'alpha2' => 'AW',
            'alpha3' => 'ABW',
            'numeric' => '533',
            'currency' => ['AWG'],
        ],

        'AU' => [
            'name' => 'Australia',
            'alpha2' => 'AU',
            'alpha3' => 'AUS',
            'numeric' => '036',
            'currency' => ['AUD'],
        ],

        'AT' => [
            'name' => 'Austria',
            'alpha2' => 'AT',
            'alpha3' => 'AUT',
            'numeric' => '040',
            'currency' => ['EUR'],
        ],

        'AZ' => [
            'name' => 'Azerbaijan',
            'alpha2' => 'AZ',
            'alpha3' => 'AZE',
            'numeric' => '031',
            'currency' => ['AZN'],
        ],

        'BS' => [
            'name' => 'Bahamas',
            'alpha2' => 'BS',
            'alpha3' => 'BHS',
            'numeric' => '044',
            'currency' => ['BSD'],
        ],

        'BH' => [
            'name' => 'Bahrain',
            'alpha2' => 'BH',
            'alpha3' => 'BHR',
            'numeric' => '048',
            'currency' => ['BHD'],
        ],

        'BD' => [
            'name' => 'Bangladesh',
            'alpha2' => 'BD',
            'alpha3' => 'BGD',
            'numeric' => '050',
            'currency' => ['BDT'],
        ],

        'BB' => [
            'name' => 'Barbados',
            'alpha2' => 'BB',
            'alpha3' => 'BRB',
            'numeric' => '052',
            'currency' => ['BBD'],
        ],

        'BY' => [
            'name' => 'Belarus',
            'alpha2' => 'BY',
            'alpha3' => 'BLR',
            'numeric' => '112',
            'currency' => ['BYN'],
        ],

        'BE' => [
            'name' => 'Belgium',
            'alpha2' => 'BE',
            'alpha3' => 'BEL',
            'numeric' => '056',
            'currency' => ['EUR'],
        ],

        'BZ' => [
            'name' => 'Belize',
            'alpha2' => 'BZ',
            'alpha3' => 'BLZ',
            'numeric' => '084',
            'currency' => ['BZD'],
        ],

        'BJ' => [
            'name' => 'Benin',
            'alpha2' => 'BJ',
            'alpha3' => 'BEN',
            'numeric' => '204',
            'currency' => ['XOF'],
        ],

        'BM' => [
            'name' => 'Bermuda',
            'alpha2' => 'BM',
            'alpha3' => 'BMU',
            'numeric' => '060',
            'currency' => ['BMD'],
        ],

        'BT' => [
            'name' => 'Bhutan',
            'alpha2' => 'BT',
            'alpha3' => 'BTN',
            'numeric' => '064',
            'currency' => ['BTN'],
        ],

        'BO' => [
            'name' => 'Bolivia (Plurinational State of)',
            'alpha2' => 'BO',
            'alpha3' => 'BOL',
            'numeric' => '068',
            'currency' => ['BOB'],
        ],

        'BQ' => [
            'name' => 'Bonaire, Sint Eustatius and Saba',
            'alpha2' => 'BQ',
            'alpha3' => 'BES',
            'numeric' => '535',
            'currency' => ['USD'],
        ],

        'BA' => [
            'name' => 'Bosnia and Herzegovina',
            'alpha2' => 'BA',
            'alpha3' => 'BIH',
            'numeric' => '070',
            'currency' => ['BAM'],
        ],

        'BW' => [
            'name' => 'Botswana',
            'alpha2' => 'BW',
            'alpha3' => 'BWA',
            'numeric' => '072',
            'currency' => ['BWP'],
        ],

        'BV' => [
            'name' => 'Bouvet Island',
            'alpha2' => 'BV',
            'alpha3' => 'BVT',
            'numeric' => '074',
            'currency' => ['NOK'],
        ],

        'BR' => [
            'name' => 'Brazil',
            'alpha2' => 'BR',
            'alpha3' => 'BRA',
            'numeric' => '076',
            'currency' => ['BRL'],
        ],

        'IO' => [
            'name' => 'British Indian Ocean Territory',
            'alpha2' => 'IO',
            'alpha3' => 'IOT',
            'numeric' => '086',
            'currency' => ['GBP'],
        ],

        'BN' => [
            'name' => 'Brunei Darussalam',
            'alpha2' => 'BN',
            'alpha3' => 'BRN',
            'numeric' => '096',
            'currency' => ['BND', 'SGD'],
        ],

        'BG' => [
            'name' => 'Bulgaria',
            'alpha2' => 'BG',
            'alpha3' => 'BGR',
            'numeric' => '100',
            'currency' => ['BGN'],
        ],

        'BF' => [
            'name' => 'Burkina Faso',
            'alpha2' => 'BF',
            'alpha3' => 'BFA',
            'numeric' => '854',
            'currency' => ['XOF'],
        ],

        'BI' => [
            'name' => 'Burundi',
            'alpha2' => 'BI',
            'alpha3' => 'BDI',
            'numeric' => '108',
            'currency' => ['BIF'],
        ],

        'CV' => [
            'name' => 'Cabo Verde',
            'alpha2' => 'CV',
            'alpha3' => 'CPV',
            'numeric' => '132',
            'currency' => ['CVE'],
        ],

        'KH' => [
            'name' => 'Cambodia',
            'alpha2' => 'KH',
            'alpha3' => 'KHM',
            'numeric' => '116',
            'currency' => ['KHR'],
        ],

        'CM' => [
            'name' => 'Cameroon',
            'alpha2' => 'CM',
            'alpha3' => 'CMR',
            'numeric' => '120',
            'currency' => ['XAF'],
        ],

        'CA' => [
            'name' => 'Canada',
            'alpha2' => 'CA',
            'alpha3' => 'CAN',
            'numeric' => '124',
            'currency' => ['CAD'],
        ],

        'KY' => [
            'name' => 'Cayman Islands',
            'alpha2' => 'KY',
            'alpha3' => 'CYM',
            'numeric' => '136',
            'currency' => ['KYD'],
        ],

        'CF' => [
            'name' => 'Central African Republic',
            'alpha2' => 'CF',
            'alpha3' => 'CAF',
            'numeric' => '140',
            'currency' => ['XAF'],
        ],

        'TD' => [
            'name' => 'Chad',
            'alpha2' => 'TD',
            'alpha3' => 'TCD',
            'numeric' => '148',
            'currency' => ['XAF'],
        ],

        'CL' => [
            'name' => 'Chile',
            'alpha2' => 'CL',
            'alpha3' => 'CHL',
            'numeric' => '152',
            'currency' => ['CLP'],
        ],

        'CN' => [
            'name' => 'China',
            'alpha2' => 'CN',
            'alpha3' => 'CHN',
            'numeric' => '156',
            'currency' => ['CNY'],
        ],

        'CX' => [
            'name' => 'Christmas Island',
            'alpha2' => 'CX',
            'alpha3' => 'CXR',
            'numeric' => '162',
            'currency' => ['AUD'],
        ],

        'CC' => [
            'name' => 'Cocos (Keeling) Islands',
            'alpha2' => 'CC',
            'alpha3' => 'CCK',
            'numeric' => '166',
            'currency' => ['AUD'],
        ],

        'CO' => [
            'name' => 'Colombia',
            'alpha2' => 'CO',
            'alpha3' => 'COL',
            'numeric' => '170',
            'currency' => ['COP'],
        ],

        'KM' => [
            'name' => 'Comoros',
            'alpha2' => 'KM',
            'alpha3' => 'COM',
            'numeric' => '174',
            'currency' => ['KMF'],
        ],

        'CG' => [
            'name' => 'Congo',
            'alpha2' => 'CG',
            'alpha3' => 'COG',
            'numeric' => '178',
            'currency' => ['XAF'],
        ],

        'CD' => [
            'name' => 'Congo (Democratic Republic of the)',
            'alpha2' => 'CD',
            'alpha3' => 'COD',
            'numeric' => '180',
            'currency' => ['CDF'],
        ],

        'CK' => [
            'name' => 'Cook Islands',
            'alpha2' => 'CK',
            'alpha3' => 'COK',
            'numeric' => '184',
            'currency' => ['NZD'],
        ],

        'CR' => [
            'name' => 'Costa Rica',
            'alpha2' => 'CR',
            'alpha3' => 'CRI',
            'numeric' => '188',
            'currency' => ['CRC'],
        ],

        'CI' => [
            'name' => 'Côte d\'Ivoire',
            'alpha2' => 'CI',
            'alpha3' => 'CIV',
            'numeric' => '384',
            'currency' => ['XOF'],
        ],

        'HR' => [
            'name' => 'Croatia',
            'alpha2' => 'HR',
            'alpha3' => 'HRV',
            'numeric' => '191',
            'currency' => ['HRK'],
        ],

        'CU' => [
            'name' => 'Cuba',
            'alpha2' => 'CU',
            'alpha3' => 'CUB',
            'numeric' => '192',
            'currency' => ['CUC', 'CUP'],
        ],

        'CW' => [
            'name' => 'Curaçao',
            'alpha2' => 'CW',
            'alpha3' => 'CUW',
            'numeric' => '531',
            'currency' => ['ANG'],
        ],

        'CY' => [
            'name' => 'Cyprus',
            'alpha2' => 'CY',
            'alpha3' => 'CYP',
            'numeric' => '196',
            'currency' => ['EUR'],
        ],

        'CZ' => [
            'name' => 'Czechia',
            'alpha2' => 'CZ',
            'alpha3' => 'CZE',
            'numeric' => '203',
            'currency' => ['CZK'],
        ],

        'DK' => [
            'name' => 'Denmark',
            'alpha2' => 'DK',
            'alpha3' => 'DNK',
            'numeric' => '208',
            'currency' => ['DKK'],
        ],

        'DJ' => [
            'name' => 'Djibouti',
            'alpha2' => 'DJ',
            'alpha3' => 'DJI',
            'numeric' => '262',
            'currency' => ['DJF'],
        ],

        'DM' => [
            'name' => 'Dominica',
            'alpha2' => 'DM',
            'alpha3' => 'DMA',
            'numeric' => '212',
            'currency' => ['XCD'],
        ],

        'do' => [
            'name' => 'Dominican Republic',
            'alpha2' => 'do',
            'alpha3' => 'DOM',
            'numeric' => '214',
            'currency' => ['DOP'],
        ],

        'EC' => [
            'name' => 'Ecuador',
            'alpha2' => 'EC',
            'alpha3' => 'ECU',
            'numeric' => '218',
            'currency' => ['USD'],
        ],

        'EG' => [
            'name' => 'Egypt',
            'alpha2' => 'EG',
            'alpha3' => 'EGY',
            'numeric' => '818',
            'currency' => ['EGP'],
        ],

        'SV' => [
            'name' => 'El Salvador',
            'alpha2' => 'SV',
            'alpha3' => 'SLV',
            'numeric' => '222',
            'currency' => ['USD'],
        ],

        'GQ' => [
            'name' => 'Equatorial Guinea',
            'alpha2' => 'GQ',
            'alpha3' => 'GNQ',
            'numeric' => '226',
            'currency' => ['XAF'],
        ],

        'ER' => [
            'name' => 'Eritrea',
            'alpha2' => 'ER',
            'alpha3' => 'ERI',
            'numeric' => '232',
            'currency' => ['ERN'],
        ],

        'EE' => [
            'name' => 'Estonia',
            'alpha2' => 'EE',
            'alpha3' => 'EST',
            'numeric' => '233',
            'currency' => ['EUR'],
        ],

        'ET' => [
            'name' => 'Ethiopia',
            'alpha2' => 'ET',
            'alpha3' => 'ETH',
            'numeric' => '231',
            'currency' => ['ETB'],
        ],

        'SZ' => [
            'name' => 'Eswatini',
            'alpha2' => 'SZ',
            'alpha3' => 'SWZ',
            'numeric' => '748',
            'currency' => ['SZL', 'ZAR'],
        ],

        'FK' => [
            'name' => 'Falkland Islands (Malvinas)',
            'alpha2' => 'FK',
            'alpha3' => 'FLK',
            'numeric' => '238',
            'currency' => ['FKP'],
        ],

        'FO' => [
            'name' => 'Faroe Islands',
            'alpha2' => 'FO',
            'alpha3' => 'FRO',
            'numeric' => '234',
            'currency' => ['DKK'],
        ],

        'FJ' => [
            'name' => 'Fiji',
            'alpha2' => 'FJ',
            'alpha3' => 'FJI',
            'numeric' => '242',
            'currency' => ['FJD'],
        ],

        'FI' => [
            'name' => 'Finland',
            'alpha2' => 'FI',
            'alpha3' => 'FIN',
            'numeric' => '246',
            'currency' => ['EUR'],
        ],

        'FR' => [
            'name' => 'France',
            'alpha2' => 'FR',
            'alpha3' => 'FRA',
            'numeric' => '250',
            'currency' => ['EUR'],
        ],

        'GF' => [
            'name' => 'French Guiana',
            'alpha2' => 'GF',
            'alpha3' => 'GUF',
            'numeric' => '254',
            'currency' => ['EUR'],
        ],

        'PF' => [
            'name' => 'French Polynesia',
            'alpha2' => 'PF',
            'alpha3' => 'PYF',
            'numeric' => '258',
            'currency' => ['XPF'],
        ],

        'TF' => [
            'name' => 'French Southern Territories',
            'alpha2' => 'TF',
            'alpha3' => 'ATF',
            'numeric' => '260',
            'currency' => ['EUR'],
        ],

        'GA' => [
            'name' => 'Gabon',
            'alpha2' => 'GA',
            'alpha3' => 'GAB',
            'numeric' => '266',
            'currency' => ['XAF'],
        ],

        'GM' => [
            'name' => 'Gambia',
            'alpha2' => 'GM',
            'alpha3' => 'GMB',
            'numeric' => '270',
            'currency' => ['GMD'],
        ],

        'GE' => [
            'name' => 'Georgia',
            'alpha2' => 'GE',
            'alpha3' => 'GEO',
            'numeric' => '268',
            'currency' => ['GEL'],
        ],

        'DE' => [
            'name' => 'Germany',
            'alpha2' => 'DE',
            'alpha3' => 'DEU',
            'numeric' => '276',
            'currency' => ['EUR'],
        ],

        'GH' => [
            'name' => 'Ghana',
            'alpha2' => 'GH',
            'alpha3' => 'GHA',
            'numeric' => '288',
            'currency' => ['GHS'],
        ],

        'GI' => [
            'name' => 'Gibraltar',
            'alpha2' => 'GI',
            'alpha3' => 'GIB',
            'numeric' => '292',
            'currency' => ['GIP'],
        ],

        'GR' => [
            'name' => 'Greece',
            'alpha2' => 'GR',
            'alpha3' => 'GRC',
            'numeric' => '300',
            'currency' => ['EUR'],
        ],

        'GL' => [
            'name' => 'Greenland',
            'alpha2' => 'GL',
            'alpha3' => 'GRL',
            'numeric' => '304',
            'currency' => ['DKK'],
        ],

        'GD' => [
            'name' => 'Grenada',
            'alpha2' => 'GD',
            'alpha3' => 'GRD',
            'numeric' => '308',
            'currency' => ['XCD'],
        ],

        'GP' => [
            'name' => 'Guadeloupe',
            'alpha2' => 'GP',
            'alpha3' => 'GLP',
            'numeric' => '312',
            'currency' => ['EUR'],
        ],

        'GU' => [
            'name' => 'Guam',
            'alpha2' => 'GU',
            'alpha3' => 'GUM',
            'numeric' => '316',
            'currency' => ['USD'],
        ],

        'GT' => [
            'name' => 'Guatemala',
            'alpha2' => 'GT',
            'alpha3' => 'GTM',
            'numeric' => '320',
            'currency' => ['GTQ'],
        ],

        'GG' => [
            'name' => 'Guernsey',
            'alpha2' => 'GG',
            'alpha3' => 'GGY',
            'numeric' => '831',
            'currency' => ['GBP'],
        ],

        'GN' => [
            'name' => 'Guinea',
            'alpha2' => 'GN',
            'alpha3' => 'GIN',
            'numeric' => '324',
            'currency' => ['GNF'],
        ],

        'GW' => [
            'name' => 'Guinea-Bissau',
            'alpha2' => 'GW',
            'alpha3' => 'GNB',
            'numeric' => '624',
            'currency' => ['XOF'],
        ],

        'GY' => [
            'name' => 'Guyana',
            'alpha2' => 'GY',
            'alpha3' => 'GUY',
            'numeric' => '328',
            'currency' => ['GYD'],
        ],

        'HT' => [
            'name' => 'Haiti',
            'alpha2' => 'HT',
            'alpha3' => 'HTI',
            'numeric' => '332',
            'currency' => ['HTG'],
        ],

        'HM' => [
            'name' => 'Heard Island and McDonald Islands',
            'alpha2' => 'HM',
            'alpha3' => 'HMD',
            'numeric' => '334',
            'currency' => ['AUD'],
        ],

        'VA' => [
            'name' => 'Holy See',
            'alpha2' => 'VA',
            'alpha3' => 'VAT',
            'numeric' => '336',
            'currency' => ['EUR'],
        ],

        'HN' => [
            'name' => 'Honduras',
            'alpha2' => 'HN',
            'alpha3' => 'HND',
            'numeric' => '340',
            'currency' => ['HNL'],
        ],

        'HK' => [
            'name' => 'Hong Kong',
            'alpha2' => 'HK',
            'alpha3' => 'HKG',
            'numeric' => '344',
            'currency' => ['HKD'],
        ],

        'HU' => [
            'name' => 'Hungary',
            'alpha2' => 'HU',
            'alpha3' => 'HUN',
            'numeric' => '348',
            'currency' => ['HUF'],
        ],

        'IS' => [
            'name' => 'Iceland',
            'alpha2' => 'IS',
            'alpha3' => 'ISL',
            'numeric' => '352',
            'currency' => ['ISK'],
        ],

        'IN' => [
            'name' => 'India',
            'alpha2' => 'IN',
            'alpha3' => 'IND',
            'numeric' => '356',
            'currency' => ['INR'],
        ],

        'ID' => [
            'name' => 'Indonesia',
            'alpha2' => 'ID',
            'alpha3' => 'IDN',
            'numeric' => '360',
            'currency' => ['IDR'],
        ],

        'IR' => [
            'name' => 'Iran (Islamic Republic of)',
            'alpha2' => 'IR',
            'alpha3' => 'IRN',
            'numeric' => '364',
            'currency' => ['IRR'],
        ],

        'IQ' => [
            'name' => 'Iraq',
            'alpha2' => 'IQ',
            'alpha3' => 'IRQ',
            'numeric' => '368',
            'currency' => ['IQD'],
        ],

        'IE' => [
            'name' => 'Ireland',
            'alpha2' => 'IE',
            'alpha3' => 'IRL',
            'numeric' => '372',
            'currency' => ['EUR'],
        ],

        'IM' => [
            'name' => 'Isle of Man',
            'alpha2' => 'IM',
            'alpha3' => 'IMN',
            'numeric' => '833',
            'currency' => ['GBP'],
        ],

        'IL' => [
            'name' => 'Israel',
            'alpha2' => 'IL',
            'alpha3' => 'ISR',
            'numeric' => '376',
            'currency' => ['ILS'],
        ],

        'IT' => [
            'name' => 'Italy',
            'alpha2' => 'IT',
            'alpha3' => 'ITA',
            'numeric' => '380',
            'currency' => ['EUR'],
        ],

        'JM' => [
            'name' => 'Jamaica',
            'alpha2' => 'JM',
            'alpha3' => 'JAM',
            'numeric' => '388',
            'currency' => ['JMD'],
        ],

        'JP' => [
            'name' => 'Japan',
            'alpha2' => 'JP',
            'alpha3' => 'JPN',
            'numeric' => '392',
            'currency' => ['JPY'],
        ],

        'JE' => [
            'name' => 'Jersey',
            'alpha2' => 'JE',
            'alpha3' => 'JEY',
            'numeric' => '832',
            'currency' => ['GBP'],
        ],

        'JO' => [
            'name' => 'Jordan',
            'alpha2' => 'JO',
            'alpha3' => 'JOR',
            'numeric' => '400',
            'currency' => ['JOD'],
        ],

        'KZ' => [
            'name' => 'Kazakhstan',
            'alpha2' => 'KZ',
            'alpha3' => 'KAZ',
            'numeric' => '398',
            'currency' => ['KZT'],
        ],

        'KE' => [
            'name' => 'Kenya',
            'alpha2' => 'KE',
            'alpha3' => 'KEN',
            'numeric' => '404',
            'currency' => ['KES'],
        ],

        'KI' => [
            'name' => 'Kiribati',
            'alpha2' => 'KI',
            'alpha3' => 'KIR',
            'numeric' => '296',
            'currency' => ['AUD'],
        ],

        'KP' => [
            'name' => 'Korea (Democratic People\'s Republic of)',
            'alpha2' => 'KP',
            'alpha3' => 'PRK',
            'numeric' => '408',
            'currency' => ['KPW'],
        ],

        'KR' => [
            'name' => 'Korea (Republic of)',
            'alpha2' => 'KR',
            'alpha3' => 'KOR',
            'numeric' => '410',
            'currency' => ['KRW'],
        ],

        'KW' => [
            'name' => 'Kuwait',
            'alpha2' => 'KW',
            'alpha3' => 'KWT',
            'numeric' => '414',
            'currency' => ['KWD'],
        ],

        'KG' => [
            'name' => 'Kyrgyzstan',
            'alpha2' => 'KG',
            'alpha3' => 'KGZ',
            'numeric' => '417',
            'currency' => ['KGS'],
        ],

        'LA' => [
            'name' => 'Lao People\'s Democratic Republic',
            'alpha2' => 'LA',
            'alpha3' => 'LAO',
            'numeric' => '418',
            'currency' => ['LAK'],
        ],

        'LV' => [
            'name' => 'Latvia',
            'alpha2' => 'LV',
            'alpha3' => 'LVA',
            'numeric' => '428',
            'currency' => ['EUR'],
        ],

        'LB' => [
            'name' => 'Lebanon',
            'alpha2' => 'LB',
            'alpha3' => 'LBN',
            'numeric' => '422',
            'currency' => ['LBP'],
        ],

        'LS' => [
            'name' => 'Lesotho',
            'alpha2' => 'LS',
            'alpha3' => 'LSO',
            'numeric' => '426',
            'currency' => ['LSL', 'ZAR'],
        ],

        'LR' => [
            'name' => 'Liberia',
            'alpha2' => 'LR',
            'alpha3' => 'LBR',
            'numeric' => '430',
            'currency' => ['LRD'],
        ],

        'LY' => [
            'name' => 'Libya',
            'alpha2' => 'LY',
            'alpha3' => 'LBY',
            'numeric' => '434',
            'currency' => ['LYD'],
        ],

        'LI' => [
            'name' => 'Liechtenstein',
            'alpha2' => 'LI',
            'alpha3' => 'LIE',
            'numeric' => '438',
            'currency' => ['CHF'],
        ],

        'LT' => [
            'name' => 'Lithuania',
            'alpha2' => 'LT',
            'alpha3' => 'LTU',
            'numeric' => '440',
            'currency' => ['EUR'],
        ],

        'LU' => [
            'name' => 'Luxembourg',
            'alpha2' => 'LU',
            'alpha3' => 'LUX',
            'numeric' => '442',
            'currency' => ['EUR'],
        ],

        'MO' => [
            'name' => 'Macao',
            'alpha2' => 'MO',
            'alpha3' => 'MAC',
            'numeric' => '446',
            'currency' => ['MOP'],
        ],

        'MK' => [
            'name' => 'North Macedonia',
            'alpha2' => 'MK',
            'alpha3' => 'MKD',
            'numeric' => '807',
            'currency' => ['MKD'],
        ],

        'MG' => [
            'name' => 'Madagascar',
            'alpha2' => 'MG',
            'alpha3' => 'MDG',
            'numeric' => '450',
            'currency' => ['MGA'],
        ],

        'MW' => [
            'name' => 'Malawi',
            'alpha2' => 'MW',
            'alpha3' => 'MWI',
            'numeric' => '454',
            'currency' => ['MWK'],
        ],

        'MY' => [
            'name' => 'Malaysia',
            'alpha2' => 'MY',
            'alpha3' => 'MYS',
            'numeric' => '458',
            'currency' => ['MYR'],
        ],

        'MV' => [
            'name' => 'Maldives',
            'alpha2' => 'MV',
            'alpha3' => 'MDV',
            'numeric' => '462',
            'currency' => ['MVR'],
        ],

        'ML' => [
            'name' => 'Mali',
            'alpha2' => 'ML',
            'alpha3' => 'MLI',
            'numeric' => '466',
            'currency' => ['XOF'],
        ],

        'MT' => [
            'name' => 'Malta',
            'alpha2' => 'MT',
            'alpha3' => 'MLT',
            'numeric' => '470',
            'currency' => ['EUR'],
        ],

        'MH' => [
            'name' => 'Marshall Islands',
            'alpha2' => 'MH',
            'alpha3' => 'MHL',
            'numeric' => '584',
            'currency' => ['USD'],
        ],

        'MQ' => [
            'name' => 'Martinique',
            'alpha2' => 'MQ',
            'alpha3' => 'MTQ',
            'numeric' => '474',
            'currency' => ['EUR'],
        ],

        'MR' => [
            'name' => 'Mauritania',
            'alpha2' => 'MR',
            'alpha3' => 'MRT',
            'numeric' => '478',
            'currency' => ['MRO'],
        ],

        'MU' => [
            'name' => 'Mauritius',
            'alpha2' => 'MU',
            'alpha3' => 'MUS',
            'numeric' => '480',
            'currency' => ['MUR'],
        ],

        'YT' => [
            'name' => 'Mayotte',
            'alpha2' => 'YT',
            'alpha3' => 'MYT',
            'numeric' => '175',
            'currency' => ['EUR'],
        ],

        'MX' => [
            'name' => 'Mexico',
            'alpha2' => 'MX',
            'alpha3' => 'MEX',
            'numeric' => '484',
            'currency' => ['MXN'],
        ],

        'FM' => [
            'name' => 'Micronesia (Federated States of)',
            'alpha2' => 'FM',
            'alpha3' => 'FSM',
            'numeric' => '583',
            'currency' => ['USD'],
        ],

        'MD' => [
            'name' => 'Moldova (Republic of)',
            'alpha2' => 'MD',
            'alpha3' => 'MDA',
            'numeric' => '498',
            'currency' => ['MDL'],
        ],

        'MC' => [
            'name' => 'Monaco',
            'alpha2' => 'MC',
            'alpha3' => 'MCO',
            'numeric' => '492',
            'currency' => ['EUR'],
        ],

        'MN' => [
            'name' => 'Mongolia',
            'alpha2' => 'MN',
            'alpha3' => 'MNG',
            'numeric' => '496',
            'currency' => ['MNT'],
        ],

        'ME' => [
            'name' => 'Montenegro',
            'alpha2' => 'ME',
            'alpha3' => 'MNE',
            'numeric' => '499',
            'currency' => ['EUR'],
        ],

        'MS' => [
            'name' => 'Montserrat',
            'alpha2' => 'MS',
            'alpha3' => 'MSR',
            'numeric' => '500',
            'currency' => ['XCD'],
        ],

        'MA' => [
            'name' => 'Morocco',
            'alpha2' => 'MA',
            'alpha3' => 'MAR',
            'numeric' => '504',
            'currency' => ['MAD'],
        ],

        'MZ' => [
            'name' => 'Mozambique',
            'alpha2' => 'MZ',
            'alpha3' => 'MOZ',
            'numeric' => '508',
            'currency' => ['MZN'],
        ],

        'MM' => [
            'name' => 'Myanmar',
            'alpha2' => 'MM',
            'alpha3' => 'MMR',
            'numeric' => '104',
            'currency' => ['MMK'],
        ],

        'NA' => [
            'name' => 'Namibia',
            'alpha2' => 'NA',
            'alpha3' => 'NAM',
            'numeric' => '516',
            'currency' => ['NAD', 'ZAR'],
        ],

        'NR' => [
            'name' => 'Nauru',
            'alpha2' => 'NR',
            'alpha3' => 'NRU',
            'numeric' => '520',
            'currency' => ['AUD'],
        ],

        'NP' => [
            'name' => 'Nepal',
            'alpha2' => 'NP',
            'alpha3' => 'NPL',
            'numeric' => '524',
            'currency' => ['NPR'],
        ],

        'NL' => [
            'name' => 'Netherlands',
            'alpha2' => 'NL',
            'alpha3' => 'NLD',
            'numeric' => '528',
            'currency' => ['EUR'],
        ],

        'NC' => [
            'name' => 'new Caledonia',
            'alpha2' => 'NC',
            'alpha3' => 'NCL',
            'numeric' => '540',
            'currency' => ['XPF'],
        ],

        'NZ' => [
            'name' => 'new Zealand',
            'alpha2' => 'NZ',
            'alpha3' => 'NZL',
            'numeric' => '554',
            'currency' => ['NZD'],
        ],

        'NI' => [
            'name' => 'Nicaragua',
            'alpha2' => 'NI',
            'alpha3' => 'NIC',
            'numeric' => '558',
            'currency' => ['NIO'],
        ],

        'NE' => [
            'name' => 'Niger',
            'alpha2' => 'NE',
            'alpha3' => 'NER',
            'numeric' => '562',
            'currency' => ['XOF'],
        ],

        'NG' => [
            'name' => 'Nigeria',
            'alpha2' => 'NG',
            'alpha3' => 'NGA',
            'numeric' => '566',
            'currency' => ['NGN'],
        ],

        'NU' => [
            'name' => 'Niue',
            'alpha2' => 'NU',
            'alpha3' => 'NIU',
            'numeric' => '570',
            'currency' => ['NZD'],
        ],

        'NF' => [
            'name' => 'Norfolk Island',
            'alpha2' => 'NF',
            'alpha3' => 'NFK',
            'numeric' => '574',
            'currency' => ['AUD'],
        ],

        'MP' => [
            'name' => 'Northern Mariana Islands',
            'alpha2' => 'MP',
            'alpha3' => 'MNP',
            'numeric' => '580',
            'currency' => ['USD'],
        ],

        'NO' => [
            'name' => 'Norway',
            'alpha2' => 'NO',
            'alpha3' => 'NOR',
            'numeric' => '578',
            'currency' => ['NOK'],
        ],

        'OM' => [
            'name' => 'Oman',
            'alpha2' => 'OM',
            'alpha3' => 'OMN',
            'numeric' => '512',
            'currency' => ['OMR'],
        ],

        'PK' => [
            'name' => 'Pakistan',
            'alpha2' => 'PK',
            'alpha3' => 'PAK',
            'numeric' => '586',
            'currency' => ['PKR'],
        ],

        'PW' => [
            'name' => 'Palau',
            'alpha2' => 'PW',
            'alpha3' => 'PLW',
            'numeric' => '585',
            'currency' => ['USD'],
        ],

        'PS' => [
            'name' => 'Palestine, State of',
            'alpha2' => 'PS',
            'alpha3' => 'PSE',
            'numeric' => '275',
            'currency' => ['ILS'],
        ],

        'PA' => [
            'name' => 'Panama',
            'alpha2' => 'PA',
            'alpha3' => 'PAN',
            'numeric' => '591',
            'currency' => ['PAB'],
        ],

        'PG' => [
            'name' => 'Papua new Guinea',
            'alpha2' => 'PG',
            'alpha3' => 'PNG',
            'numeric' => '598',
            'currency' => ['PGK'],
        ],

        'PY' => [
            'name' => 'Paraguay',
            'alpha2' => 'PY',
            'alpha3' => 'PRY',
            'numeric' => '600',
            'currency' => ['PYG'],
        ],

        'PE' => [
            'name' => 'Peru',
            'alpha2' => 'PE',
            'alpha3' => 'PER',
            'numeric' => '604',
            'currency' => ['PEN'],
        ],

        'PH' => [
            'name' => 'Philippines',
            'alpha2' => 'PH',
            'alpha3' => 'PHL',
            'numeric' => '608',
            'currency' => ['PHP'],
        ],

        'PN' => [
            'name' => 'Pitcairn',
            'alpha2' => 'PN',
            'alpha3' => 'PCN',
            'numeric' => '612',
            'currency' => ['NZD'],
        ],

        'PL' => [
            'name' => 'Poland',
            'alpha2' => 'PL',
            'alpha3' => 'POL',
            'numeric' => '616',
            'currency' => ['PLN'],
        ],

        'PT' => [
            'name' => 'Portugal',
            'alpha2' => 'PT',
            'alpha3' => 'PRT',
            'numeric' => '620',
            'currency' => ['EUR'],
        ],

        'PR' => [
            'name' => 'Puerto Rico',
            'alpha2' => 'PR',
            'alpha3' => 'PRI',
            'numeric' => '630',
            'currency' => ['USD'],
        ],

        'QA' => [
            'name' => 'Qatar',
            'alpha2' => 'QA',
            'alpha3' => 'QAT',
            'numeric' => '634',
            'currency' => ['QAR'],
        ],

        'RE' => [
            'name' => 'Réunion',
            'alpha2' => 'RE',
            'alpha3' => 'REU',
            'numeric' => '638',
            'currency' => ['EUR'],
        ],

        'RO' => [
            'name' => 'Romania',
            'alpha2' => 'RO',
            'alpha3' => 'ROU',
            'numeric' => '642',
            'currency' => ['RON'],
        ],

        'RU' => [
            'name' => 'Russian Federation',
            'alpha2' => 'RU',
            'alpha3' => 'RUS',
            'numeric' => '643',
            'currency' => ['RUB'],
        ],

        'RW' => [
            'name' => 'Rwanda',
            'alpha2' => 'RW',
            'alpha3' => 'RWA',
            'numeric' => '646',
            'currency' => ['RWF'],
        ],

        'BL' => [
            'name' => 'Saint Barthélemy',
            'alpha2' => 'BL',
            'alpha3' => 'BLM',
            'numeric' => '652',
            'currency' => ['EUR'],
        ],

        'SH' => [
            'name' => 'Saint Helena, Ascension and Tristan da Cunha',
            'alpha2' => 'SH',
            'alpha3' => 'SHN',
            'numeric' => '654',
            'currency' => ['SHP'],
        ],

        'KN' => [
            'name' => 'Saint Kitts and Nevis',
            'alpha2' => 'KN',
            'alpha3' => 'KNA',
            'numeric' => '659',
            'currency' => ['XCD'],
        ],

        'LC' => [
            'name' => 'Saint Lucia',
            'alpha2' => 'LC',
            'alpha3' => 'LCA',
            'numeric' => '662',
            'currency' => ['XCD'],
        ],

        'MF' => [
            'name' => 'Saint Martin (French part)',
            'alpha2' => 'MF',
            'alpha3' => 'MAF',
            'numeric' => '663',
            'currency' => ['EUR', 'USD'],
        ],

        'PM' => [
            'name' => 'Saint Pierre and Miquelon',
            'alpha2' => 'PM',
            'alpha3' => 'SPM',
            'numeric' => '666',
            'currency' => ['EUR'],
        ],

        'VC' => [
            'name' => 'Saint Vincent and the Grenadines',
            'alpha2' => 'VC',
            'alpha3' => 'VCT',
            'numeric' => '670',
            'currency' => ['XCD'],
        ],

        'WS' => [
            'name' => 'Samoa',
            'alpha2' => 'WS',
            'alpha3' => 'WSM',
            'numeric' => '882',
            'currency' => ['WST'],
        ],

        'SM' => [
            'name' => 'San Marino',
            'alpha2' => 'SM',
            'alpha3' => 'SMR',
            'numeric' => '674',
            'currency' => ['EUR'],
        ],

        'ST' => [
            'name' => 'Sao Tome and Principe',
            'alpha2' => 'ST',
            'alpha3' => 'STP',
            'numeric' => '678',
            'currency' => ['STD'],
        ],

        'SA' => [
            'name' => 'Saudi Arabia',
            'alpha2' => 'SA',
            'alpha3' => 'SAU',
            'numeric' => '682',
            'currency' => ['SAR'],
        ],

        'SN' => [
            'name' => 'Senegal',
            'alpha2' => 'SN',
            'alpha3' => 'SEN',
            'numeric' => '686',
            'currency' => ['XOF'],
        ],

        'RS' => [
            'name' => 'Serbia',
            'alpha2' => 'RS',
            'alpha3' => 'SRB',
            'numeric' => '688',
            'currency' => ['RSD'],
        ],

        'SC' => [
            'name' => 'Seychelles',
            'alpha2' => 'SC',
            'alpha3' => 'SYC',
            'numeric' => '690',
            'currency' => ['SCR'],
        ],

        'SL' => [
            'name' => 'Sierra Leone',
            'alpha2' => 'SL',
            'alpha3' => 'SLE',
            'numeric' => '694',
            'currency' => ['SLL'],
        ],

        'SG' => [
            'name' => 'Singapore',
            'alpha2' => 'SG',
            'alpha3' => 'SGP',
            'numeric' => '702',
            'currency' => ['SGD'],
        ],

        'SX' => [
            'name' => 'Sint Maarten (Dutch part)',
            'alpha2' => 'SX',
            'alpha3' => 'SXM',
            'numeric' => '534',
            'currency' => ['ANG'],
        ],

        'SK' => [
            'name' => 'Slovakia',
            'alpha2' => 'SK',
            'alpha3' => 'SVK',
            'numeric' => '703',
            'currency' => ['EUR'],
        ],

        'SI' => [
            'name' => 'Slovenia',
            'alpha2' => 'SI',
            'alpha3' => 'SVN',
            'numeric' => '705',
            'currency' => ['EUR'],
        ],

        'SB' => [
            'name' => 'Solomon Islands',
            'alpha2' => 'SB',
            'alpha3' => 'SLB',
            'numeric' => '090',
            'currency' => ['SBD'],
        ],

        'SO' => [
            'name' => 'Somalia',
            'alpha2' => 'SO',
            'alpha3' => 'SOM',
            'numeric' => '706',
            'currency' => ['SOS'],
        ],

        'ZA' => [
            'name' => 'South Africa',
            'alpha2' => 'ZA',
            'alpha3' => 'ZAF',
            'numeric' => '710',
            'currency' => ['ZAR'],
        ],

        'GS' => [
            'name' => 'South Georgia and the South Sandwich Islands',
            'alpha2' => 'GS',
            'alpha3' => 'SGS',
            'numeric' => '239',
            'currency' => ['GBP'],
        ],

        'SS' => [
            'name' => 'South Sudan',
            'alpha2' => 'SS',
            'alpha3' => 'SSD',
            'numeric' => '728',
            'currency' => ['SSP'],
        ],

        'ES' => [
            'name' => 'Spain',
            'alpha2' => 'ES',
            'alpha3' => 'ESP',
            'numeric' => '724',
            'currency' => ['EUR'],
        ],

        'LK' => [
            'name' => 'Sri Lanka',
            'alpha2' => 'LK',
            'alpha3' => 'LKA',
            'numeric' => '144',
            'currency' => ['LKR'],
        ],

        'SD' => [
            'name' => 'Sudan',
            'alpha2' => 'SD',
            'alpha3' => 'SDN',
            'numeric' => '729',
            'currency' => ['SDG'],
        ],

        'SR' => [
            'name' => 'Suriname',
            'alpha2' => 'SR',
            'alpha3' => 'SUR',
            'numeric' => '740',
            'currency' => ['SRD'],
        ],

        'SJ' => [
            'name' => 'Svalbard and Jan Mayen',
            'alpha2' => 'SJ',
            'alpha3' => 'SJM',
            'numeric' => '744',
            'currency' => ['NOK'],
        ],

        'SE' => [
            'name' => 'Sweden',
            'alpha2' => 'SE',
            'alpha3' => 'SWE',
            'numeric' => '752',
            'currency' => ['SEK'],
        ],

        'CH' => [
            'name' => 'Switzerland',
            'alpha2' => 'CH',
            'alpha3' => 'CHE',
            'numeric' => '756',
            'currency' => ['CHF'],
        ],

        'SY' => [
            'name' => 'Syrian Arab Republic',
            'alpha2' => 'SY',
            'alpha3' => 'SYR',
            'numeric' => '760',
            'currency' => ['SYP'],
        ],

        'TW' => [
            'name' => 'Taiwan (Province of China)',
            'alpha2' => 'TW',
            'alpha3' => 'TWN',
            'numeric' => '158',
            'currency' => ['TWD'],
        ],

        'TJ' => [
            'name' => 'Tajikistan',
            'alpha2' => 'TJ',
            'alpha3' => 'TJK',
            'numeric' => '762',
            'currency' => ['TJS'],
        ],

        'TZ' => [
            'name' => 'Tanzania, United Republic of',
            'alpha2' => 'TZ',
            'alpha3' => 'TZA',
            'numeric' => '834',
            'currency' => ['TZS'],
        ],

        'TH' => [
            'name' => 'Thailand',
            'alpha2' => 'TH',
            'alpha3' => 'THA',
            'numeric' => '764',
            'currency' => ['THB'],
        ],

        'TL' => [
            'name' => 'Timor-Leste',
            'alpha2' => 'TL',
            'alpha3' => 'TLS',
            'numeric' => '626',
            'currency' => ['USD'],
        ],

        'TG' => [
            'name' => 'Togo',
            'alpha2' => 'TG',
            'alpha3' => 'TGO',
            'numeric' => '768',
            'currency' => ['XOF'],
        ],

        'TK' => [
            'name' => 'Tokelau',
            'alpha2' => 'TK',
            'alpha3' => 'TKL',
            'numeric' => '772',
            'currency' => ['NZD'],
        ],

        'TO' => [
            'name' => 'Tonga',
            'alpha2' => 'TO',
            'alpha3' => 'TON',
            'numeric' => '776',
            'currency' => ['TOP'],
        ],

        'TT' => [
            'name' => 'Trinidad and Tobago',
            'alpha2' => 'TT',
            'alpha3' => 'TTO',
            'numeric' => '780',
            'currency' => ['TTD'],
        ],

        'TN' => [
            'name' => 'Tunisia',
            'alpha2' => 'TN',
            'alpha3' => 'TUN',
            'numeric' => '788',
            'currency' => ['TND'],
        ],

        'TR' => [
            'name' => 'Turkey',
            'alpha2' => 'TR',
            'alpha3' => 'TUR',
            'numeric' => '792',
            'currency' => ['try'],
        ],

        'TM' => [
            'name' => 'Turkmenistan',
            'alpha2' => 'TM',
            'alpha3' => 'TKM',
            'numeric' => '795',
            'currency' => ['TMT'],
        ],

        'TC' => [
            'name' => 'Turks and Caicos Islands',
            'alpha2' => 'TC',
            'alpha3' => 'TCA',
            'numeric' => '796',
            'currency' => ['USD'],
        ],

        'TV' => [
            'name' => 'Tuvalu',
            'alpha2' => 'TV',
            'alpha3' => 'TUV',
            'numeric' => '798',
            'currency' => ['AUD'],
        ],

        'UG' => [
            'name' => 'Uganda',
            'alpha2' => 'UG',
            'alpha3' => 'UGA',
            'numeric' => '800',
            'currency' => ['UGX'],
        ],

        'UA' => [
            'name' => 'Ukraine',
            'alpha2' => 'UA',
            'alpha3' => 'UKR',
            'numeric' => '804',
            'currency' => ['UAH'],
        ],

        'AE' => [
            'name' => 'United Arab Emirates',
            'alpha2' => 'AE',
            'alpha3' => 'ARE',
            'numeric' => '784',
            'currency' => ['AED'],
        ],

        'GB' => [
            'name' => 'United Kingdom of Great Britain and Northern Ireland',
            'alpha2' => 'GB',
            'alpha3' => 'GBR',
            'numeric' => '826',
            'currency' => ['GBP'],
        ],

        'US' => [
            'name' => 'United States of America',
            'alpha2' => 'US',
            'alpha3' => 'USA',
            'numeric' => '840',
            'currency' => ['USD'],
        ],

        'UM' => [
            'name' => 'United States Minor Outlying Islands',
            'alpha2' => 'UM',
            'alpha3' => 'UMI',
            'numeric' => '581',
            'currency' => ['USD'],
        ],

        'UY' => [
            'name' => 'Uruguay',
            'alpha2' => 'UY',
            'alpha3' => 'URY',
            'numeric' => '858',
            'currency' => ['UYU'],
        ],

        'UZ' => [
            'name' => 'Uzbekistan',
            'alpha2' => 'UZ',
            'alpha3' => 'UZB',
            'numeric' => '860',
            'currency' => ['UZS'],
        ],

        'VU' => [
            'name' => 'Vanuatu',
            'alpha2' => 'VU',
            'alpha3' => 'VUT',
            'numeric' => '548',
            'currency' => ['VUV'],
        ],

        'VE' => [
            'name' => 'Venezuela (Bolivarian Republic of)',
            'alpha2' => 'VE',
            'alpha3' => 'VEN',
            'numeric' => '862',
            'currency' => ['VEF'],
        ],

        'VN' => [
            'name' => 'Viet Nam',
            'alpha2' => 'VN',
            'alpha3' => 'VNM',
            'numeric' => '704',
            'currency' => ['VND'],
        ],

        'VG' => [
            'name' => 'Virgin Islands (British)',
            'alpha2' => 'VG',
            'alpha3' => 'VGB',
            'numeric' => '092',
            'currency' => ['USD'],
        ],

        'VI' => [
            'name' => 'Virgin Islands (U.S.)',
            'alpha2' => 'VI',
            'alpha3' => 'VIR',
            'numeric' => '850',
            'currency' => ['USD'],
        ],

        'WF' => [
            'name' => 'Wallis and Futuna',
            'alpha2' => 'WF',
            'alpha3' => 'WLF',
            'numeric' => '876',
            'currency' => ['XPF'],
        ],

        'EH' => [
            'name' => 'Western Sahara',
            'alpha2' => 'EH',
            'alpha3' => 'ESH',
            'numeric' => '732',
            'currency' => ['MAD'],
        ],

        'YE' => [
            'name' => 'Yemen',
            'alpha2' => 'YE',
            'alpha3' => 'YEM',
            'numeric' => '887',
            'currency' => ['YER'],
        ],

        'ZM' => [
            'name' => 'Zambia',
            'alpha2' => 'ZM',
            'alpha3' => 'ZMB',
            'numeric' => '894',
            'currency' => ['ZMW'],
        ],

        'ZW' => [
            'name' => 'Zimbabwe',
            'alpha2' => 'ZW',
            'alpha3' => 'ZWE',
            'numeric' => '716',
            'currency' => ['BWP', 'EUR', 'GBP', 'USD', 'ZAR'],
        ],
    ];
}
