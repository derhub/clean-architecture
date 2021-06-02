<?php

namespace Tests\Shared\Utils;

use Derhub\Shared\Utils\CountryLookup;
use PHPUnit\Framework\TestCase;

class CountryLookupTest extends TestCase
{
    public function testFindByAlpha2(): void
    {
//        $result = '[';
//        foreach (CountryLookup::all() as $country) {
//            $currency = '[';
//            foreach ($country['currency'] as $key => $item) {
//                if ($key !== 0) {
//                    $currency .= ',';
//                }
//                $currency .= "'{$item}'";
//
//            }
//            $currency .= ']';
//            $result .= "
//                '{$country['alpha2']}' => [
//                    'name' => '{$country['name']}',
//                    'alpha2' => '{$country['alpha2']}',
//                    'alpha3' => '{$country['alpha3']}',
//                    'numeric' => '{$country['numeric']}',
//                    'currency' => {$currency},
//                ],
//            ";
//        }
//        $result .= '];';


        $result = CountryLookup::fromAlpha2('DK');
        self::assertIsArray($result);
        self::assertIsString($result[CountryLookup::KEY_NUMERIC]);
        self::assertIsString($result[CountryLookup::KEY_ALPHA3]);
        self::assertIsString($result[CountryLookup::KEY_ALPHA2]);
        self::assertIsString($result[CountryLookup::KEY_NAME]);
        self::assertIsArray($result[CountryLookup::KEY_CURRENCY]);
    }
}
