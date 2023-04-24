<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductIdentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('Product_Ident')->delete();
        $idents = [
            [
                '_id' => 1,
                'name' => 'Other',
                'regex' => '',
                'category' => 'Other',
                'basePrice' => 10,
                'food' => false
            ], [
                '_id' => 2,
                'name' => 'sör',
                'regex' => '/(?i)(sör$|sör |radler)/',
                'category' => 'Szeszesitalok',
                'basePrice' => 658,
                'food' => true
            ], [
                '_id' => 3,
                'name' => 'pezsgő',
                'regex' => '/(?i)(pezsgő$|pezsgő )/',
                'category' => 'Szeszesitalok',
                'basePrice' => 1945,
                'food' => true
            ], [
                '_id' => 4,
                'name' => 'puding',
                'regex' => '/(?i)(puding$|puding )/',
                'category' => 'Tejtermékek',
                'basePrice' => 5946,
                'food' => true
            ], [
                '_id' => 5,
                'name' => 'pudingpor',
                'regex' => '/(?i)(puding\s*por$|puding\s*por )/',
                'category' => 'Tejtermékek',
                'basePrice' => 5946,
                'food' => true
            ], [
                '_id' => 6,
                'name' => 'tejföl',
                'regex' => '/(?i)(föl$|föl )/',
                'category' => 'Tejtermékek',
                'basePrice' => 1209,
                'food' => true
            ], [
                '_id' => 7,
                'name' => 'tej',
                'regex' => '/(?i)(tej$|tej )/',
                'category' => 'Tejtermékek',
                'basePrice' => 349,
                'food' => true
            ], [
                '_id' => 8,
                'name' => 'macskaeledel',
                'regex' => '/(?i)(macskaeledel$|macskaeledel )/',
                'category' => 'Állateledelek',
                'basePrice' => 1176,
                'food' => true
            ], [
                '_id' => 9,
                'name' => 'kutyaeledel',
                'regex' => '/(?i)(kutyaeledel$|kutyaeledel )/',
                'category' => 'Állateledelek',
                'basePrice' => 765,
                'food' => true
            ], [
                '_id' => 10,
                'name' => 'bébiétel',
                'regex' => '/(?i)(bébimenü$|bébimenü |tápszer$|tápszer )/',
                'category' => 'bébiételek',
                'basePrice' => 2814,
                'food' => true
            ], [
                '_id' => 11,
                'name' => 'sampon',
                'regex' => '/(?i)(sampon$|sampon )/',
                'category' => 'tisztálkodás',
                'basePrice' => 3998,
                'food' => false
            ], [
                '_id' => 12,
                'name' => 'pelenka',
                'regex' => '/(?i)(pelenka$|pelenka |pelenka)/',
                'category' => 'tisztálkodás',
                'basePrice' => 102,
                'food' => false
            ], [
                '_id' => 13,
                'name' => 'bébi törlőkendő',
                'regex' => '/(?i)(^(?=.*(\bbaba))(\s*)(?=.*kend).*$)/',
                'category' => 'tisztálkodás',
                'basePrice' => 14,
                'food' => false
            ], [
                '_id' => 14,
                'name' => 'virsli',
                'regex' => '/(?i)(virsli$|virsli |füstli$|füstli |rudacska$|rudacska |vürstli$|vürstli |FRANKFURTI$|FRANKFURTI )/',
                'category' => 'húsfélék',
                'basePrice' => 2797,
                'food' => true
            ], [
                '_id' => 15,
                'name' => 'fogkefe',
                'regex' => '/(?i)(fogkefe$|fogkefe )/',
                'category' => 'tisztálkodás',
                'basePrice' => 1279,
                'food' => false
            ], [
                '_id' => 16,
                'name' => 'fogkrém',
                'regex' => '/(?i)(fogkrém$|fogkrém )/',
                'category' => 'tisztálkodás',
                'basePrice' => 21320,
                'food' => false
            ], [
                '_id' => 17,
                'name' => 'konzerv uborka',
                'regex' => '/(?i)(^(?=.*(\bcsemege|\bsavany|\bkov))(\s*)(?=.*uborka).*$)/',
                'category' => 'konzerv',
                'basePrice' => 1997,
                'food' => true
            ], [
                '_id' => 18,
                'name' => 'debreceni',
                'regex' => '/(?i)(debreceni$|debreceni )/',
                'category' => 'húsfélék',
                'basePrice' => 2330,
                'food' => true
            ], [
                '_id' => 19,
                'name' => 'kolbász',
                'regex' => '/(?i)(kolbász$|kolbász )/',
                'category' => 'húsfélék',
                'basePrice' => 3190,
                'food' => true
            ], [
                '_id' => 20,
                'name' => 'parizer',
                'regex' => '/(?i)(párizsi$|párizsi |parizer$|parizer )/',
                'category' => 'húsfélék',
                'basePrice' => 3290,
                'food' => true
            ], [
                '_id' => 21,
                'name' => 'felvágott',
                'regex' => '/(?i)(felvágott$|felvágott )/',
                'category' => 'húsfélék',
                'basePrice' => 2193,
                'food' => true
            ], [
                '_id' => 22,
                'name' => 'szalámi',
                'regex' => '/(?i)(szalámi$|szalámi )/',
                'category' => 'húsfélék',
                'basePrice' => 5497,
                'food' => true
            ], [
                '_id' => 23,
                'name' => 'májkrém',
                'regex' => '/(?i)(májas$|májas |májkrém$|májkrém )/',
                'category' => 'húsfélék',
                'basePrice' => 1592,
                'food' => true
            ], [
                '_id' => 24,
                'name' => 'sonka',
                'regex' => '/(?i)(sonka$|sonka )/',
                'category' => 'húsfélék',
                'basePrice' => 2124,
                'food' => true
            ], [
                '_id' => 25,
                'name' => 'szendvicsfeltét',
                'regex' => '/(?i)(szendvicsfeltét$|szendvicsfeltét )/',
                'category' => 'húsfélék',
                'basePrice' => 2495,
                'food' => true
            ], [
                '_id' => 26,
                'name' => 'bacon',
                'regex' => '/(?i)(bacon$|bacon |baconszalonna)/',
                'category' => 'húsfélék',
                'basePrice' => 4660,
                'food' => true
            ], [
                '_id' => 27,
                'name' => 'pástétom',
                'regex' => '/(?i)(pástétom$|pástétom )/',
                'category' => 'húsfélék',
                'basePrice' => 3069,
                'food' => true
            ], [
                '_id' => 28,
                'name' => 'csirke',
                'regex' => '/(?i)(^(?=.*(\beg))(\s*)(?=.*csirke).*$)/',
                'category' => 'húsfélék',
                'basePrice' => 929,
                'food' => true
            ], [
                '_id' => 29,
                'name' => 'csirkecomb',
                'regex' => '/(?i)(^(?=.*(\bcsirke))(\s*)(?=.*comb).*$)/',
                'category' => 'húsfélék',
                'basePrice' => 999,
                'food' => true
            ], [
                '_id' => 30,
                'name' => 'comb',
                'regex' => '/(?i)(comb$|comb )/',
                'category' => 'húsfélék',
                'basePrice' => 1738,
                'food' => true
            ], [
                '_id' => 31,
                'name' => 'sertéscsont',
                'regex' => '/(?i)(^(?=.*(\bsert\b|\bdiszn\b))(\s*)(?=.*csont).*$)/',
                'category' => 'húsfélék',
                'basePrice' => 729,
                'food' => true
            ], [
                '_id' => 32,
                'name' => 'sertés szűzpecsenye',
                'regex' => '/(?i)(^(?=.*(\bsert\b|\bdiszn\b))(\s*)(?=.*sz[\s\S]z).*$)/',
                'category' => 'húsfélék',
                'basePrice' => 2779,
                'food' => true
            ], [
                '_id' => 33,
                'name' => 'sertés darálthús',
                'regex' => '/(?i)(^(?=.*(\bsert\b|\bdiszn\b))(\s*)(?=.*dar).*$)/',
                'category' => 'húsfélék',
                'basePrice' => 1779,
                'food' => true
            ], [
                '_id' => 34,
                'name' => 'sertés lapocka',
                'regex' => '/(?i)(^(?=.*(\bsert\b|\bdiszn\b))(\s*)(?=.*lapocka).*$)/',
                'category' => 'húsfélék',
                'basePrice' => 1969,
                'food' => true
            ], [
                '_id' => 35,
                'name' => 'szalonna',
                'regex' => '/(?i)(szalonna$|szalonna )/',
                'category' => 'húsfélék',
                'basePrice' => 2299,
                'food' => true
            ], [
                '_id' => 36,
                'name' => 'tarja',
                'regex' => '/(?i)(tarja$|tarja )/',
                'category' => 'húsfélék',
                'basePrice' => 2229,
                'food' => true
            ], [
                '_id' => 37,
                'name' => 'narancs',
                'regex' => '/(?i)(^(?!.*ital).?^(?!.*fanta).?^(?!.*lé)).*narancs.*/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 349,
                'food' => true
            ], [
                '_id' => 38,
                'name' => 'citrom',
                'regex' => '/(?i)(^(?!.*citromos).?^(?!.*fanta).?^(?!.*lé)).*citrom.*/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 798,
                'food' => true
            ], [
                '_id' => 39,
                'name' => 'sárgadinnye',
                'regex' => '/(?i)(sárgadinnye$|sárgadinnye )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 699,
                'food' => true
            ], [
                '_id' => 40,
                'name' => 'alma',
                'regex' => '/(?i)(^(?!.*szirom).?^(?!.*lé).?^(?!.*almás)).*alma.*|almák/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 369,
                'food' => true
            ], [
                '_id' => 41,
                'name' => 'hagyma',
                'regex' => '/(?i)(^(?!.*fok).?^(?!.*medve)).*hagyma.*/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 399,
                'food' => true
            ], [
                '_id' => 42,
                'name' => 'szőlő',
                'regex' => '/(?i)(szőlő$|szőlő |szöllő$|szöllő )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 1399,
                'food' => true
            ], [
                '_id' => 43,
                'name' => 'eper',
                'regex' => '/(?i)(eper$|eper )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 1598,
                'food' => true
            ], [
                '_id' => 44,
                'name' => 'áfonya',
                'regex' => '/(?i)(áfonya$|áfonya )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 5663,
                'food' => true
            ], [
                '_id' => 45,
                'name' => 'füge',
                'regex' => '/(?i)(füge$|füge )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 2245,
                'food' => true
            ], [
                '_id' => 46,
                'name' => ' aszaltszilva',
                'regex' => '/(?i)(aszaltszilva$|aszaltszilva |aszalt szilva$|aszalt szilva )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 2995,
                'food' => true
            ], [
                '_id' => 47,
                'name' => 'édesbugonya',
                'regex' => '/(?i)(édesburgonya$|édesburgonya |édes burgonya$|édes burgonya )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 499,
                'food' => true
            ], [
                '_id' => 48,
                'name' => 'retek',
                'regex' => '/(?i)(retek$|retek )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 349,
                'food' => true
            ], [
                '_id' => 49,
                'name' => 'fokhagyma',
                'regex' => '/(?i)(fokhagyma$|fokhagyma )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 1299,
                'food' => true
            ], [
                '_id' => 50,
                'name' => 'fejessaláta',
                'regex' => '/(?i)(fejessaláta$|fejessaláta |fejes saláta$|fejes saláta )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 269,
                'food' => true
            ], [
                '_id' => 51,
                'name' => 'jégsaláta',
                'regex' => '/(?i)(jégsaláta$|jégsaláta |jég saláta$|jég saláta )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 299,
                'food' => true
            ], [
                '_id' => 52,
                'name' => 'paradicsom',
                'regex' => '/(?i)(^(?!.*paszírozott).?^(?!.*püré).?^(?!.*paradicsomos).?^(?!.*paradicsomlé).?^(?!.*szósz).?^(?!.*ültető)).*paradicsom.*/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 994,
                'food' => true
            ], [
                '_id' => 53,
                'name' => 'uborka',
                'regex' => '/(?i)(uborka$|uborka )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 249,
                'food' => true
            ], [
                '_id' => 54,
                'name' => 'paprika',
                'regex' => '/(?i)(^(?!.*f[\s\S]szer).?^(?!.*kr[\s\S]m)).*paprika.*/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 1399,
                'food' => true
            ], [
                '_id' => 55,
                'name' => 'cukkini',
                'regex' => '/(?i)(cukkini$|cukkini )/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 1399,
                'food' => true
            ], [
                '_id' => 56,
                'name' => 'karfiol',
                'regex' => '/(?i)(^(?!.*rántott)).*karfiol.*/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 699,
                'food' => true
            ], [
                '_id' => 57,
                'name' => 'vaj',
                'regex' => '/(?i)(^(?!.*kr[\s\S]m)).*vaj.*/',
                'category' => 'Tejtermékek',
                'basePrice' => 3290,
                'food' => true
            ], [
                '_id' => 58,
                'name' => 'juhtúró',
                'regex' => '/(?i)(juh\s*túró)/',
                'category' => 'Tejtermékek',
                'basePrice' => 3190,
                'food' => true
            ], [
                '_id' => 59,
                'name' => 'körözött',
                'regex' => '/(?i)(körözött$|körözött )/',
                'category' => 'Tejtermékek',
                'basePrice' => 2193,
                'food' => true
            ], [
                '_id' => 60,
                'name' => 'túró',
                'regex' => '/(?i)(^(?!.*rudi).?^(?!.*juh).?^(?!.*bonbon)).*túró.*/',
                'category' => 'Tejtermékek',
                'basePrice' => 1796,
                'food' => true
            ], [
                '_id' => 61,
                'name' => 'tejberizs',
                'regex' => '/(?i)(tejberizs$|tejberizs )/',
                'category' => 'Tejtermékek',
                'basePrice' => 995,
                'food' => true
            ], [
                '_id' => 62,
                'name' => 'túró rudi',
                'regex' => '/(?i)(túrórudi$|túrórudi |túró rudi$|túró rudi )/',
                'category' => 'Tejtermékek',
                'basePrice' => 6105,
                'food' => true
            ], [
                '_id' => 63,
                'name' => 'kefir',
                'regex' => '/(?i)(kefir$|kefir |kefír$|kefír )/',
                'category' => 'Tejtermékek',
                'basePrice' => 993,
                'food' => true
            ], [
                '_id' => 64,
                'name' => 'joghurt',
                'regex' => '/(?i)(joghurt$|joghurt )/',
                'category' => 'Tejtermékek',
                'basePrice' => 531,
                'food' => true
            ], [
                '_id' => 65,
                'name' => 'tejital',
                'regex' => '/(?i)(tejital$|tejital )/',
                'category' => 'Tejtermékek',
                'basePrice' => 913,
                'food' => true
            ], [
                '_id' => 66,
                'name' => 'tejszin',
                'regex' => '/(?i)(tejszín$|tejszín |tejszin$|tejszin )/',
                'category' => 'Tejtermékek',
                'basePrice' => 1495,
                'food' => true
            ], [
                '_id' => 67,
                'name' => 'sajt',
                'regex' => '/(?i)(^(?!.*parenyica).?^(?!.*feta).?^(?!.*rántott)).*sajt.*/',
                'category' => 'Tejtermékek',
                'basePrice' => 4284,
                'food' => true
            ], [
                '_id' => 68,
                'name' => 'parenyica',
                'regex' => '/(?i)(parenyica$|parenyica )/',
                'category' => 'Tejtermékek',
                'basePrice' => 4752,
                'food' => true
            ], [
                '_id' => 69,
                'name' => 'feta',
                'regex' => '/(?i)(feta$|feta )/',
                'category' => 'Tejtermékek',
                'basePrice' => 3996,
                'food' => true
            ], [
                '_id' => 70,
                'name' => 'majonéz',
                'regex' => '/(?i)(majonéz$|majonéz )/',
                'category' => 'Tejtermékek',
                'basePrice' => 1998,
                'food' => true
            ], [
                '_id' => 71,
                'name' => 'bagett',
                'regex' => '/(?i)(bagett$|bagett )/',
                'category' => 'Pékáru',
                'basePrice' => 1047,
                'food' => true
            ], [
                '_id' => 72,
                'name' => 'csiga',
                'regex' => '/(?i)(^(?!.*tészta).?^(?!.*juh).?^(?!.*bonbon)).*csiga.*/',
                'category' => 'Pékáru',
                'basePrice' => 991,
                'food' => true
            ], [
                '_id' => 73,
                'name' => 'kenyér',
                'regex' => '/(?i)(kenyér$|kenyér )/',
                'category' => 'Pékáru',
                'basePrice' => 1196,
                'food' => true
            ], [
                '_id' => 74,
                'name' => 'kifli',
                'regex' => '/(?i)(kifli$|kifli )/',
                'category' => 'Pékáru',
                'basePrice' => 989,
                'food' => true
            ], [
                '_id' => 75,
                'name' => 'táska',
                'regex' => '/(?i)(s táska$|s táska )/',
                'category' => 'Pékáru',
                'basePrice' => 1545,
                'food' => true
            ], [
                '_id' => 76,
                'name' => 'briós',
                'regex' => '/(?i)(briós$|briós )/',
                'category' => 'Pékáru',
                'basePrice' => 2433,
                'food' => true
            ], [
                '_id' => 77,
                'name' => 'pogácsa',
                'regex' => '/(?i)(^(?!.*hús)).*pogácsa.*/',
                'category' => 'Pékáru',
                'basePrice' => 1362,
                'food' => true
            ], [
                '_id' => 78,
                'name' => 'zöldborsó',
                'regex' => '/(?i)(zöldborsó$|zöldborsó )/',
                'category' => 'mirelit',
                'basePrice' => 679,
                'food' => true
            ], [
                '_id' => 79,
                'name' => 'zöldbab',
                'regex' => '/(?i)(zöldbab$|zöldbab )/',
                'category' => 'mirelit',
                'basePrice' => 639,
                'food' => true
            ], [
                '_id' => 80,
                'name' => 'sóska',
                'regex' => '/(?i)(sóska$|sóska )/',
                'category' => 'mirelit',
                'basePrice' => 886,
                'food' => true
            ], [
                '_id' => 81,
                'name' => 'camembert',
                'regex' => '/(?i)(^(?!.*panírozott)).*camembert.*/',
                'category' => 'Tejtermékek',
                'basePrice' => 886,
                'food' => true
            ], [
                '_id' => 82,
                'name' => 'panírozott camembert',
                'regex' => '/(?i)(panírozott camembert$|panírozott camembert )/',
                'category' => 'mirelit',
                'basePrice' => 2854,
                'food' => true
            ], [
                '_id' => 83,
                'name' => 'rántott sajt',
                'regex' => '/(?i)(rántottsajt$|rántottsajt |rántott sajt$|rántott sajt )/',
                'category' => 'mirelit',
                'basePrice' => 1998,
                'food' => true
            ], [
                '_id' => 84,
                'name' => 'fánk',
                'regex' => '/(?i)(fánk$|fánk )/',
                'category' => 'Pékáru',
                'basePrice' => 1998,
                'food' => true
            ], [
                '_id' => 85,
                'name' => 'rántott karfiol',
                'regex' => '/(?i)(rántott karfiol$)|(rántott karfiol )|(rántottkarfiol$|rántottkarfiol )/',
                'category' => 'mirelit',
                'basePrice' => 2220,
                'food' => true
            ], [
                '_id' => 86,
                'name' => 'hekk',
                'regex' => '/(?i)(hekk$|hekk |hekk)/',
                'category' => 'mirelit',
                'basePrice' => 1498,
                'food' => true
            ], [
                '_id' => 87,
                'name' => 'halászlé',
                'regex' => '/(?i)(halászlé$|halászlé )/',
                'category' => 'mirelit',
                'basePrice' => 1495,
                'food' => true
            ], [
                '_id' => 88,
                'name' => 'ponty',
                'regex' => '/(?i)(ponty$|ponty |ponty)/',
                'category' => 'mirelit',
                'basePrice' => 3701,
                'food' => true
            ], [
                '_id' => 89,
                'name' => 'csikemáj',
                'regex' => '/(?i)(csirkemáj$|csirkemáj |csirke máj$|csirke máj)/',
                'category' => 'húsfélék',
                'basePrice' => 798,
                'food' => true
            ], [
                '_id' => 90,
                'name' => 'húsgolyó',
                'regex' => '/(?i)(húsgolyó$|húsgolyó )/',
                'category' => 'húsfélék',
                'basePrice' => 2331,
                'food' => true
            ], [
                '_id' => 91,
                'name' => 'sajttal töltött mell',
                'regex' => '/(?i)(^(?=.*(\bsajt))(\s*)(?=.*mell).*$)/',
                'category' => 'mirelit',
                'basePrice' => 1199,
                'food' => true
            ], [
                '_id' => 92,
                'name' => 'panírozott karaj',
                'regex' => '/(?i)(^(?=.*(\bpanírozott))(\s*)(?=.*karaj).*$)/',
                'category' => 'mirelit',
                'basePrice' => 1798,
                'food' => true
            ], [
                '_id' => 93,
                'name' => 'sztrapacska',
                'regex' => '/(?i)(sztrapacska$|sztrapacska )/',
                'category' => 'mirelit',
                'basePrice' => 849,
                'food' => true
            ], [
                '_id' => 94,
                'name' => 'kaszinótojás',
                'regex' => '/(?i)(^(?=.*(\bkaszinó))(\s*)(?=.*tojás).*$)/',
                'category' => 'mirelit',
                'basePrice' => 2245,
                'food' => true
            ], [
                '_id' => 95,
                'name' => 'palacsinta',
                'regex' => '/(?i)(palacsinta$|palacsinta )/',
                'category' => 'mirelit',
                'basePrice' => 2330,
                'food' => true
            ], [
                '_id' => 96,
                'name' => 'tavaszi tekercs',
                'regex' => '/(?i)(^(?=.*(\btavaszi))(\s*)(?=.*tekercs).*$)/',
                'category' => 'mirelit',
                'basePrice' => 3210,
                'food' => true
            ], [
                '_id' => 97,
                'name' => 'kalács',
                'regex' => '/(?i)(kalács$|kalács )/',
                'category' => 'Pékáru',
                'basePrice' => 1298,
                'food' => true
            ], [
                '_id' => 98,
                'name' => 'piskóta',
                'regex' => '/(?i)(piskóta$|piskóta )/',
                'category' => 'Pékáru',
                'basePrice' => 2496,
                'food' => true
            ], [
                '_id' => 99,
                'name' => 'liszt',
                'regex' => '/(?i)(liszt)/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 180,
                'food' => true
            ], [
                '_id' => 100,
                'name' => 'rizs',
                'regex' => '/(?i)(^(?!.*tejbe)).*rizs.*/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 499,
                'food' => true
            ], [
                '_id' => 101,
                'name' => 'tészta',
                'regex' => '/(?i)(^(?!.*lasagne)).*tészta.*/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 999,
                'food' => true
            ], [
                '_id' => 102,
                'name' => 'lasagne',
                'regex' => '/(?i)(lasagne)/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 1098,
                'food' => true
            ], [
                '_id' => 103,
                'name' => 'sütőmargarin',
                'regex' => '/(?i)(sütőmargarin|sütő margarin)/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 1996,
                'food' => true
            ], [
                '_id' => 104,
                'name' => 'kókuszolaj',
                'regex' => '/(?i)(^(?=.*(\bkókusz))(\s*)(?=.*olaj).*$)/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 1899,
                'food' => true
            ], [
                '_id' => 105,
                'name' => 'eritrit',
                'regex' => '/(?i)(eritrit)/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 1996,
                'food' => true
            ], [
                '_id' => 106,
                'name' => 'méz',
                'regex' => '/(?i)(^(?!.*mézes)).*méz.*/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 3998,
                'food' => true
            ], [
                '_id' => 107,
                'name' => 'torma',
                'regex' => '/(?i)(torma)/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 2363,
                'food' => true
            ], [
                '_id' => 108,
                'name' => 'bors',
                'regex' => '/(?i)(^(?!.*borsos).?^(?!.*borsó)).*bors.*/',
                'category' => 'Fűszerek',
                'basePrice' => 6237,
                'food' => true
            ], [
                '_id' => 109,
                'name' => 'fűszersó',
                'regex' => '/(?i)(fűszersó)/',
                'category' => 'Fűszerek',
                'basePrice' => 6030,
                'food' => true
            ], [
                '_id' => 110,
                'name' => 'leves',
                'regex' => '/(?i)(^(?!.*zöldség)).*leves.*/',
                'category' => 'Fűszerek',
                'basePrice' => 9282,
                'food' => true
            ], [
                '_id' => 111,
                'name' => 'ételízesítő',
                'regex' => '/(?i)(ételízesítő|ételizesítő)/',
                'category' => 'Fűszerek',
                'basePrice' => 2496,
                'food' => true
            ], [
                '_id' => 112,
                'name' => 'müzli',
                'regex' => '/(?i)(müzli)/',
                'category' => 'Édességek',
                'basePrice' => 5950,
                'food' => true
            ], [
                '_id' => 113,
                'name' => 'zabpehely',
                'regex' => '/(?i)(zabpehely)/',
                'category' => 'Édességek',
                'basePrice' => 1398,
                'food' => true
            ], [
                '_id' => 114,
                'name' => 'vaníliarúd',
                'regex' => '/(?i)(^(?=.*(\bvanília))(\s*)(?=.*rúd).*$)/',
                'category' => 'Fűszerek',
                'basePrice' => 799,
                'food' => true
            ], [
                '_id' => 115,
                'name' => 'kókuszreszelék',
                'regex' => '/(?i)(^(?=.*(\bkókusz))(\s*)(?=.*reszelék).*$)/',
                'category' => 'Fűszerek',
                'basePrice' => 1745,
                'food' => true
            ], [
                '_id' => 116,
                'name' => 'szezámmag',
                'regex' => '/(?i)(^(?=.*(\bszezám))(\s*)(?=.*mag).*$)/',
                'category' => 'Fűszerek',
                'basePrice' => 1995,
                'food' => true
            ], [
                '_id' => 117,
                'name' => 'vanillincukor',
                'regex' => '/(?i)(^(?=.*(\bvan))(\s*)(?=.*cukor).*$)/',
                'category' => 'Fűszerek',
                'basePrice' => 996,
                'food' => true
            ], [
                '_id' => 118,
                'name' => 'bab',
                'regex' => '/(?i)(^(?!.*zöld).?^(?!.*borsó)).*bab.*/',
                'category' => 'zöldség gyümölcs',
                'basePrice' => 712,
                'food' => true
            ], [
                '_id' => 119,
                'name' => 'passzírozott paradicsom',
                'regex' => '/(?i)(^(?=.*(\bpaszírozott))(\s*)(?=.*paradicsom).*$)/',
                'category' => 'konzerv',
                'basePrice' => 793,
                'food' => true
            ], [
                '_id' => 120,
                'name' => 'kukorica',
                'regex' => '/(?i)(kukorica)/',
                'category' => 'konzerv',
                'basePrice' => 1751,
                'food' => true
            ], [
                '_id' => 121,
                'name' => 'löncshús',
                'regex' => '/(?i)(löncs)|(luncheon)/',
                'category' => 'konzerv',
                'basePrice' => 1247,
                'food' => true
            ], [
                '_id' => 122,
                'name' => 'tonhal',
                'regex' => '/(?i)(tonhal)/',
                'category' => 'konzerv',
                'basePrice' => 2955,
                'food' => true
            ], [
                '_id' => 123,
                'name' => 'kávé',
                'regex' => '/(?i)(kávé)|(café)/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 2699,
                'food' => true
            ], [
                '_id' => 124,
                'name' => 'kakaó',
                'regex' => '/(?i)(^(?!.*ital).?^(?!.*kakaós)).*kakaó.*/',
                'category' => 'Főzési alapanyagok',
                'basePrice' => 2306,
                'food' => true
            ], [
                '_id' => 125,
                'name' => 'ásványvíz',
                'regex' => '/(?i)(ásványvíz)|szódavíz/',
                'category' => 'Üdítők',
                'basePrice' => 113,
                'food' => true
            ], [
                '_id' => 126,
                'name' => 'paradicsomlé',
                'regex' => '/(?i)(paradicsomlé)/',
                'category' => 'Üdítők',
                'basePrice' => 449,
                'food' => true
            ], [
                '_id' => 127,
                'name' => 'cola',
                'regex' => '/(?i)(cola)|(kóla)|pepsi/',
                'category' => 'Üdítők',
                'basePrice' => 339,
                'food' => true
            ], [
                '_id' => 128,
                'name' => 'ital',
                'regex' => '/(?i)(^(?!.*szesz).?^(?!.*alkohol)).*ital.*/',
                'category' => 'Üdítők',
                'basePrice' => 339,
                'food' => true
            ], [
                '_id' => 129,
                'name' => 'konyak',
                'regex' => '/(?i)(brandy)|(cognac)|(konyak)|napoleon/',
                'category' => 'Szeszesitalok',
                'basePrice' => 5713,
                'food' => true
            ], [
                '_id' => 130,
                'name' => 'whiky',
                'regex' => '/(?i)(whisky)|(whiskey)/',
                'category' => 'Szeszesitalok',
                'basePrice' => 10998,
                'food' => true
            ], [
                '_id' => 131,
                'name' => 'vodka',
                'regex' => '/(?i)(vodka)/',
                'category' => 'Szeszesitalok',
                'basePrice' => 4398,
                'food' => true
            ], [
                '_id' => 132,
                'name' => 'pálinka',
                'regex' => '/(?i)(pálinka)/',
                'category' => 'Szeszesitalok',
                'basePrice' => 6598,
                'food' => true
            ], [
                '_id' => 133,
                'name' => 'bor',
                'regex' => '/(?i)(^(?!.*bors).?^(?!.*borsó)).*bor.*|olaszrizling|cuvée|irsai olivér|kékfrankos|rosé/',
                'category' => 'Szeszesitalok',
                'basePrice' => 799,
                'food' => true
            ], [
                '_id' => 134,
                'name' => 'martini',
                'regex' => '/(?i)(martini)/',
                'category' => 'Szeszesitalok',
                'basePrice' => 3598,
                'food' => true
            ], [
                '_id' => 135,
                'name' => 'ropi',
                'regex' => '/(?i)(ropi)|(sós pálcika)/',
                'category' => 'Édességek',
                'basePrice' => 3533,
                'food' => true
            ], [
                '_id' => 136,
                'name' => 'chips',
                'regex' => '/(?i)(chips)|(csipsz)|(big\s*pep)|(burgonyaszirom)|(burgonyszirom)/',
                'category' => 'Édességek',
                'basePrice' => 3995,
                'food' => true
            ], [
                '_id' => 137,
                'name' => 'földimogyoró',
                'regex' => '/(?i)(földimogyoró)/',
                'category' => 'Édességek',
                'basePrice' => 1598,
                'food' => true
            ], [
                '_id' => 138,
                'name' => 'tökmag',
                'regex' => '/(?i)(tökmag)/',
                'category' => 'Édességek',
                'basePrice' => 2395,
                'food' => true
            ], [
                '_id' => 139,
                'name' => 'kesudió',
                'regex' => '/(?i)(kesudió)/',
                'category' => 'Édességek',
                'basePrice' => 4495,
                'food' => true
            ], [
                '_id' => 140,
                'name' => 'almaszirom',
                'regex' => '/(?i)(almaszirom)|(alma szirom)/',
                'category' => 'Édességek',
                'basePrice' => 3580,
                'food' => true
            ], [
                '_id' => 141,
                'name' => 'keksz',
                'regex' => '/(?i)(keksz)/',
                'category' => 'Édességek',
                'basePrice' => 758,
                'food' => true
            ], [
                '_id' => 142,
                'name' => 'vaníliás karika',
                'regex' => '/(?i)(vaníliás karika)|(vaníliáskarika)/',
                'category' => 'Édességek',
                'basePrice' => 1993,
                'food' => true
            ], [
                '_id' => 143,
                'name' => 'ostya',
                'regex' => '/(?i)(ostya)/',
                'category' => 'Édességek',
                'basePrice' => 1699,
                'food' => true
            ], [
                '_id' => 144,
                'name' => 'csokoládé',
                'regex' => '/(?i)(^(?!.*csokoládés).?^(?!.*csokis))(.*csokoládé.*|csoki)|praliné/',
                'category' => 'Édességek',
                'basePrice' => 2996,
                'food' => true
            ], [
                '_id' => 145,
                'name' => 'mosóporgélszer',
                'regex' => '/(?i)(mosó)/',
                'category' => 'Tisztítószerek',
                'basePrice' => 1262,
                'food' => false
            ], [
                '_id' => 146,
                'name' => 'öblítő',
                'regex' => '/(?i)(öblítő)/',
                'category' => 'Tisztítószerek',
                'basePrice' => 845,
                'food' => false
            ], [
                '_id' => 147,
                'name' => 'színfogó kendő',
                'regex' => '/(?i)(^(?=.*(\bszínfogó|\bdiszn))(\s*)(?=.*kendő).*$)/',
                'category' => 'Tisztítószerek',
                'basePrice' => 23,
                'food' => false
            ], [
                '_id' => 148,
                'name' => 'mosogatószer',
                'regex' => '/(?i)(mosogató)/',
                'category' => 'Tisztítószerek',
                'basePrice' => 65,
                'food' => false
            ], [
                '_id' => 149,
                'name' => 'fertőtlenítő',
                'regex' => '/(?i)(fertőtlenítő)/',
                'category' => 'Tisztítószerek',
                'basePrice' => 638,
                'food' => false
            ], [
                '_id' => 150,
                'name' => 'fehérítő',
                'regex' => '/(?i)(fehérítő)/',
                'category' => 'Tisztítószerek',
                'basePrice' => 638,
                'food' => false
            ], [
                '_id' => 151,
                'name' => 'wc tisztító',
                'regex' => '/(?i)(wc tisztító)|(wctisztító)/',
                'category' => 'Tisztítószerek',
                'basePrice' => 865,
                'food' => false
            ], [
                '_id' => 152,
                'name' => 'egészségügyi betét',
                'regex' => '/(?i)(egészségügyi\s*betét|tisztasági\s*betét|szárnyas\s*betét|tampon)/',
                'category' => 'tisztálkodás',
                'basePrice' => 45,
                'food' => false
            ], [
                '_id' => 153,
                'name' => 'szappan',
                'regex' => '/(?i)(szappan)/',
                'category' => 'tisztálkodás',
                'basePrice' => 449,
                'food' => false
            ], [
                '_id' => 154,
                'name' => 'tusfürdő',
                'regex' => '/(?i)(tusfürdő)/',
                'category' => 'tisztálkodás',
                'basePrice' => 2298,
                'food' => false
            ], [
                '_id' => 155,
                'name' => 'dezodor',
                'regex' => '/(?i)(deo)|(dezodor)/',
                'category' => 'tisztálkodás',
                'basePrice' => 6660,
                'food' => false
            ], [
                '_id' => 156,
                'name' => 'wc papír',
                'regex' => '/(?i)(^(?=.*(\bwc|\btoalett|\bwécé))(\s*)(?=.*papír).*$)/',
                'category' => 'tisztálkodás',
                'basePrice' => 74,
                'food' => false
            ], [
                '_id' => 157,
                'name' => 'papírtörlő',
                'regex' => '/(?i)(papírtörlő)/',
                'category' => 'tisztálkodás',
                'basePrice' => 125,
                'food' => false
            ], [
                '_id' => 158,
                'name' => 'szalvéta',
                'regex' => '/(?i)(szalvéta)/',
                'category' => 'tisztálkodás',
                'basePrice' => 3,
                'food' => false
            ], [
                '_id' => 159,
                'name' => 'elem',
                'regex' => '/(?i)(elem)/',
                'category' => 'tisztálkodás',
                'basePrice' => 166,
                'food' => false
            ]
        ];
        DB::table('Product_Ident')->insert($idents);
    }
}
