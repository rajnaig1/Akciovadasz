<?php

namespace App\Services;

use App\Outside_Resources\OutsideResponse;
use App\Repositories\TescoRepository;
use Exception;

class TescoService
{
    protected $outsideResponse;
    protected $tescoRepository;
    public function __construct(OutsideResponse $outsideResponse, TescoRepository $tescoRepository)
    {
        $this->outsideResponse = $outsideResponse;
        $this->tescoRepository = $tescoRepository;
    }
    public function storeTesco()
    {
        $tesco = $this->outsideResponse->tescoTotal();
        $this->tescoRepository->wipeProducts();
        if (!$tesco->hasNext && $this->checkIfNextProductQuantityIsFalse($tesco)) {
            return $this->iterateProducts($tesco);
            return 'entered';
        } else {
            throw new Exception('There are more products than queried');
        }
    }
    private function checkIfNextProductQuantityIsFalse($tesco)
    {
        if ($tesco->nextProductsQty == 0) {
            return true;
        }
        return false;
    }
    private function iterateProducts($tesco)
    {
        $productArray = $tesco->products;
        $i = 0;
        $templateArray = [];
        foreach ($productArray as $product) {
            $productObject = (object)[];
            $this->generalObjectProperties($product, $productObject);
            if ($product->name == 'Kinder Bueno White vagy Kinder Bueno') {
                //dd($product);
            }
            if ($product->data->template->type == 'x_plus_one') {
                $productObject->template = 'x_plus_one';
                //array_push($templateArray,$this->handleXPlusOne($product,$productObject));
                $this->handleXPlusOne($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == 'clubcard_blue_border') {
                $productObject->template = 'clubcard_blue_border';
                //array_push($templateArray, $this->handleBlueCard($product, $productObject));
                $this->handleBlueCard($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == 'cheapest_for_free') {
                $productObject->template = 'cheapest for free';
                //array_push($templateArray, $this->handleCheapestForFree($product, $productObject));
                $this->handleCheapestForFree($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == 'normal_price') {
                $productObject->template = 'normal price';
                //array_push($templateArray, $this->handleNormalPrice($product, $productObject));
                $this->handleNormalPrice($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == 'saving_higher_than_10') {
                //több mit 10%-os spórolás
                $productObject->template = 'saving higher than 10';
                //array_push($templateArray, $this->handleSavingHigherThan10($product, $productObject));
                $this->handleSavingHigherThan10($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == "clubcard_department_discount_with_price_blue_border") {
                //u.a. mint a blue border, bizonyos helyeken nem elérhető
                $productObject->template = 'clubcard_department_discount_with_price_blue_border';
                //array_push($templateArray, $this->handleDiscountWithPriceBlueBorder($product, $productObject));
                $this->handleSavingHigherThan10($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == "x_offer_2_tier") {
                // ha többet veszel olcsóbb, ha kevesebbet drágább
                $productObject->template = 'x_offer_2_tier';
                //array_push($templateArray, $this->handle2Tier($product, $productObject));
                $this->handle2Tier($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == "normal_price_yellow") {
                //Nem kedvezménes
                $productObject->template = 'normal price yellow';
                //array_push($templateArray, $this->handleNormalPriceYellow($product, $productObject));
                $this->handleNormalPriceYellow($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == "clubcard_tier_2_saving_lower_than_10") {
                //ua mint a blue border
                $productObject->template = 'clubcard_tier_2_saving_lower_than_10';
                //array_push($templateArray, $this->handleTier2LowerThan10($product, $productObject));
                $this->handleTier2LowerThan10($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else if ($product->data->template->type == "clubcard_department_discount_promo_with_price_blue_border") {
                //Kedvezmény minden tesco lazúrfestékre
                $productObject->template = 'clubcard_department_discount_promo_with_price_blue_border';
                //array_push($templateArray, $this->handleDepartmentDiscount($product, $productObject));
                $this->handleDepartmentDiscount($product, $productObject);
                $this->tescoRepository->storeProduct($productObject);
            } else {
                throw new Exception('Tesco Ismeretlen termékkategória');
            }
        }
        //dd((object)array_filter($templateArray));
        //dd((object)array_filter($templateArray)['378']);
    }
    private function generalObjectProperties($product, $productObject)
    {
        $productObject->name = $product->name;
        $productObject->url = $product->url;
        $productObject->active = $product->active;
        $productObject->offerBegin = $product->offerbegin;
        $productObject->offerEnd = $product->offerend;
        $productObject->imageURL = $product->imageurl;
        //Általános objektumtulajdonságok
        //mindnek van name-e
        //mindnek van url-e
        //active true false
        //offerbegin mindnek van
        //offerend mindnek van
        //imageurl mindnek van
        //Template-ek
    }
    private function handleXPlusOne($product, $productObject)
    {
        //descriptionben van a kilós ár ,-vel elválasztva
        $unitPriceAndUnit = explode(',', $product->description);
        //kilós ár
        $unitPrice = trim(explode('/', $unitPriceAndUnit[count($unitPriceAndUnit) - 1])[0], " Ft");
        //kiló
        $unit = (trim(explode('/', $unitPriceAndUnit[count($unitPriceAndUnit) - 1])[1]));
        $unit = explode(' ', $unit)[1];
        $comment = $product->data->template->data->unit . ' vásárlása esetén';
        $productObject->unit = $unit;
        $productObject->comment = $comment;
        $productObject->bestUnitPrice = $unitPrice;
        $productObject->bestPrice = $product->data->template->data->price;
        //dd($product);
        return $productObject;
    }
    private function handleBlueCard($product, $productObject)
    {
        $unit = "";
        $data = (array)($product->data->template->data);
        $clubcard = (array)($data)['clubcard-price'];
        if (isset($product->data->template->data->unit)) {
            $this->unitGivenInJsonClubcard($data, $clubcard, $product, $productObject);
        }
        if (!isset($product->data->template->data->unit)) {
            $pattern = $this->regexCollector('kgOrLiter');
            $patternSpecialGramm = $this->regexCollector('gramm');
            $patternSpecialDarab = $this->regexCollector('darab');
            $patternSpecialMilliliter = $this->regexCollector('milliliter');

            if (isset($data['si-unit'])) {
                $this->handleBlueCardSiUnit($data, $clubcard, $product, $productObject);
            } else if (\preg_match($pattern, $product->description) == 1) {
                \preg_match_all($pattern, $product->description, $matches);
                $productObject->comment = $product->description;
                $this->clubCardUnitPrice($clubcard, $data, $product, $productObject);
                $this->unitMatcher($matches, $productObject);
            } else if (\preg_match($patternSpecialGramm, $product->description)) {
                \preg_match_all($patternSpecialGramm, $product->description, $matches);
                $productObject->comment = $product->description;
                $this->clubCardUnitPrice($clubcard, $data, $product, $productObject);
                $this->unitMatcher($matches, $productObject);
                $convertToKilogramFactor = $this->unitPriceGrammMatcher($matches);
                if ($productObject->bestUnitPrice == '') {
                    $productObject->bestUnitPrice = (int)round($productObject->bestPrice * $convertToKilogramFactor, 0);
                }
            } else if (\preg_match($patternSpecialDarab, $product->description)) {
                \preg_match_all($patternSpecialDarab, $product->description, $matches);
                $productObject->comment = $product->description;
                $this->clubCardUnitPrice($clubcard, $data, $product, $productObject);
                $this->unitMatcher($matches, $productObject);
                $convertToDarabFactor = $this->unitPriceDarabMatcher($matches);
                if ($productObject->bestUnitPrice == '') {
                    $productObject->bestUnitPrice = (int)round($productObject->bestPrice * $convertToDarabFactor, 0);
                }
            } else if (\preg_match($patternSpecialMilliliter, $product->description)) {
                \preg_match_all($patternSpecialMilliliter, $product->description, $matches);
                $productObject->comment = $product->description;
                $this->clubCardUnitPrice($clubcard, $data, $product, $productObject);
                $this->unitMatcher($matches, $productObject);
                $convertToLiterFactor = $this->unitPriceMilliLiterMatcher($matches);
                if ($productObject->bestUnitPrice == '') {
                    $productObject->bestUnitPrice = (int)round($productObject->bestPrice * $convertToLiterFactor, 0);
                }
            } else {
                $productObject->unit = 'db';
                $productObject->comment = $product->description;
                $this->clubCardUnitPrice($clubcard, $data, $product, $productObject);
            }
        }
        return $productObject;
    }
    private function unitMatcher($matches, $productObject)
    {
        $kg = '/kg/';
        $liter = '/ l/';
        $liter2 = '/[0-9]l/';
        $gramm = '/ g/';
        $gramm2 = '/[0-9]g/';
        $darab = '/db/';
        $milliliter = '/ml/';
        foreach ($matches as $match) {
            if (\preg_match($kg, $match[0])) {
                $productObject->unit = 'kg';
                return $productObject;
            } else if (\preg_match($liter, $match[0])) {
                $productObject->unit = 'l';
                return $productObject;
            } else if (\preg_match($liter2, $match[0])) {
                $productObject->unit = 'l';
                return $productObject;
            } else if (\preg_match($gramm, $match[0])) {
                $productObject->unit = 'kg';
                return $productObject;
            } else if (\preg_match($darab, $match[0])) {
                $productObject->unit = 'db';
                return $productObject;
            } else if (\preg_match($gramm2, $match[0])) {
                $productObject->unit = 'kg';
                return $productObject;
            } else if (\preg_match($milliliter, $match[0])) {
                $productObject->unit = 'l';
                return $productObject;
            }
        }
    }
    private function unitPriceGrammMatcher($matches)
    {
        foreach ($matches as $match) {
            $quantity = trim(rtrim($match[0], 'g'));
            $convertToKilogram = 1000 / $quantity;
            return $convertToKilogram;
        }
    }
    private function unitPriceMilliLiterMatcher($matches)
    {
        foreach ($matches as $match) {
            $quantity = trim(rtrim($match[0], 'ml'));
            $convertToLiter = 1000 / $quantity;
            return $convertToLiter;
        }
    }
    private function unitPriceDarabMatcher($matches)
    {
        foreach ($matches as $match) {
            $quantity = trim(rtrim($match[0], 'db'));
            $convertToPricePerDarab = 1 / $quantity;
            return $convertToPricePerDarab;
        }
    }
    private function unitGivenInData($product, $data)
    {
        $unit = $product->data->template->data->unit;
        if ($unit == 'db-tól') {
            $unit = 'db';
        }
        if ($unit == 'cs' || $unit == 'db' || $unit == 'cs-tól') {
            if (isset($data['si-unit']) && $data['si-unit'] != "") {
                $unit = $data['si-unit'];
                $unit = explode(' ', $unit);
                if (count($unit) > 1) {
                    $unit = $unit[1];
                } else {
                    $unit = substr($unit[0], 1);
                }
            } else {
                $unit = 'db';
            }
        }
        return $unit;
    }
    private function unitGivenInJsonClubcard($data, $clubcard, $product, $productObject)
    {
        $unit = $this->unitGivenInData($product, $data);
        $productObject->unit = $unit;
        $productObject->comment = $product->description;
        $this->clubCardUnitPrice($clubcard, $data, $product, $productObject);
    }
    private function clubCardUnitPrice($clubcard, $data, $product, $productObject)
    {
        $unitExists = isset($product->data->template->data->unit);
        $unitPriceArray = (array)($clubcard)['si-unit-price'];
        $unitPrice = $unitPriceArray['val'];
        if ($unitPrice == "") {
            $unitPrice = $unitPriceArray['list'];
            $unitPrice = explode(',', $unitPrice)[0];
        }
        if ($unitPrice == "" && $unitExists && ($product->data->template->data->unit == 'cs' || $product->data->template->data->unit == 'cs-tól')) {
            if (\preg_match($this->regexCollector('cs'), $product->description)) {
                \preg_match_all($this->regexCollector('cs'), $product->description, $matches);
                $darabConversionFactor = $this->unitPriceDarabMatcher($matches);
                $unitPrice = (int)round($clubcard['price'] * $darabConversionFactor, 0);
            }
        }
        $productObject->bestUnitPrice = $unitPrice;
        $productObject->bestPrice = $clubcard['price'];
    }
    private function handleBlueCardSiUnit($data, $clubcard, $product, $productObject)
    {
        $unit = explode(' ', $data['si-unit']);

        $this->clubCardUnitPrice($clubcard, $data, $product, $productObject);
        $productObject->comment = $product->description;
        if (count($unit) > 1) {
            $productObject->unit = $unit[1];
        } else {
            $productObject->unit = $unit[0];
        }
    }
    private function handleCheapestForFree($product, $productObject)
    {
        $productObject->unit = 'Not implemented';
        $productObject->comment = $product->description;
        $productObject->bestUnitPrice = 10000000;
        $productObject->bestPrice = 10000000;
        return $productObject;
    }
    private function handleNormalPrice($product, $productObject)
    {
        $data = (array)($product->data->template->data);
        if (isset($product->data->template->data->unit)) {
            $unit = $this->unitGivenInData($product, $data);
            $productObject->unit = $unit;
            $productObject->comment = $product->description;
            $this->normalUnitPrice($data, $product, $productObject);
        }
        if (!isset($product->data->template->data->unit)) {
            $pattern = $this->regexCollector('kgOrLiter');
            $patternSpecialGramm = $this->regexCollector('gramm');
            $patternSpecialDarab = $this->regexCollector('darab');
            $patternSpecialMilliliter = $this->regexCollector('milliliter');

            if (isset($data['si-unit'])) {
                $this->handleNormalSiUnit($data, $product, $productObject);
            } else if (\preg_match($pattern, $product->description) == 1) {
                \preg_match_all($pattern, $product->description, $matches);
                $productObject->comment = $product->description;
                $this->normalUnitPrice($data, $product, $productObject);
                $this->unitMatcher($matches, $productObject);
            } else if (\preg_match($patternSpecialGramm, $product->description)) {
                \preg_match_all($patternSpecialGramm, $product->description, $matches);
                $productObject->comment = $product->description;
                $this->normalUnitPrice($data, $product, $productObject);
                $this->unitMatcher($matches, $productObject);
                $convertToKilogramFactor = $this->unitPriceGrammMatcher($matches);
                if ($productObject->bestUnitPrice == '') {
                    $productObject->bestUnitPrice = (int)round($productObject->bestPrice * $convertToKilogramFactor, 0);
                }
            } else if (\preg_match($patternSpecialDarab, $product->description)) {
                \preg_match_all($patternSpecialDarab, $product->description, $matches);
                $productObject->comment = $product->description;
                $this->normalUnitPrice($data, $product, $productObject);
                $this->unitMatcher($matches, $productObject);
                $convertToDarabFactor = $this->unitPriceDarabMatcher($matches);
                if ($productObject->bestUnitPrice == '') {
                    $productObject->bestUnitPrice = (int)round($productObject->bestPrice * $convertToDarabFactor, 0);
                }
            } else if (\preg_match($patternSpecialMilliliter, $product->description)) {
                \preg_match_all($patternSpecialMilliliter, $product->description, $matches);
                $productObject->comment = $product->description;
                $this->normalUnitPrice($data, $product, $productObject);
                $this->unitMatcher($matches, $productObject);
                $convertToLiterFactor = $this->unitPriceMilliLiterMatcher($matches);
                if ($productObject->bestUnitPrice == '') {
                    $productObject->bestUnitPrice = (int)round($productObject->bestPrice * $convertToLiterFactor, 0);
                }
            } else {
                $productObject->unit = 'db';
                $productObject->comment = $product->description;
                $this->normalUnitPrice($data, $product, $productObject);
            }
        }
        //return $product;
        return $productObject;
    }
    private function normalUnitPrice($data, $product, $productObject)
    {
        $unitPriceArray = (array)($data)['si-unit-price'];
        $unitPrice = $unitPriceArray['val'];
        if ($unitPrice == "") {
            $unitPrice = $unitPriceArray['list'];
            $unitPrice = explode(',', $unitPrice)[0];
        }
        if ($unitPrice == "" && isset($data["unit"]) && ($data["unit"] == 'cs' || $data["unit"] == 'cs-tól')) {
            if (\preg_match($this->regexCollector('cs'), $product->description)) {
                \preg_match_all($this->regexCollector('cs'), $product->description, $matches);
                $darabConversionFactor = $this->unitPriceDarabMatcher($matches);
                $unitPrice = (int)round($data['price'] * $darabConversionFactor, 0);
            }
        }
        $productObject->bestUnitPrice = $unitPrice;
        $productObject->bestPrice = $data['price'];
    }
    private function regexCollector($type)
    {
        if ($type == 'cs') {
            return  '/([0-9] db)|([0-9][0-9] db)|([0-9][0-9][0-9] db)|([0-9]db)|([0-9][0-9]db)|([0-9][0-9][0-9]db)/';
        } else if ($type == 'kgOrLiter') {
            return  "/([0-9] kg)|([0-9][0-9] kg)|([0-9] l)|([0-9][0-9] l|[0-9]kg)|([0-9][0-9]kg)|([0-9]l)|([0-9][0-9]l)/";
        } else if ($type == 'gramm') {
            return "/([0-9] g)|([0-9][0-9] g)|([0-9][0-9][0-9] g)|([0-9][0-9][0-9][0-9] g)|([0-9]g)|([0-9][0-9]g)|([0-9][0-9][0-9]g)|([0-9][0-9][0-9][0-9]g)/";
        } else if ($type == 'darab') {
            return "/([0-9] db)|([0-9][0-9] db)|([0-9][0-9][0-9] db)|([0-9]db)|([0-9][0-9]db)|([0-9][0-9][0-9]db)/";
        } else if ($type == 'milliliter') {
            return "/([0-9] ml)|([0-9][0-9] ml)|([0-9][0-9][0-9] ml)|([0-9][0-9][0-9][0-9] ml)|([0-9]ml)|([0-9][0-9]ml)|([0-9][0-9][0-9]ml)|([0-9][0-9][0-9][0-9]ml)/";
        }
    }
    private function handleNormalSiUnit($data, $product, $productObject)
    {
        $unit = explode(' ', $data['si-unit']);

        $this->normalUnitPrice($data, $product, $productObject);
        $productObject->comment = $product->description;
        if (count($unit) > 1) {
            $productObject->unit = $unit[1];
        } else {
            $productObject->unit = $unit[0];
        }
    }
    private function handleSavingHigherThan10($product, $productObject)
    {
        return $this->handleNormalPrice($product, $productObject);
    }
    private function handleDiscountWithPriceBlueBorder($product, $productObject)
    {
        return $this->handleBlueCard($product, $productObject);
    }
    private function handle2Tier($product, $productObject)
    {
        $productObject->comment = $product->description;
        $productObject->bestPrice = $product->data->template->data->price;
        $this->tier2UnitPriceCatcher($productObject, $product->description);
        return $productObject;
    }
    private function tier2UnitPriceCatcher($productObject, $description)
    {
        $kgPattern = '/([0-9][0-9][0-9][0-9][0-9]\s*Ft\/1\s*kg)|([0-9][0-9][0-9][0-9]\s*Ft\/1\s*kg)|([0-9][0-9][0-9]\s*Ft\/1\s*kg)|([0-9][0-9]\s*Ft\/1\s*kg)|([0-9]\s*Ft\/1\s*kg)/';
        $literPattern = '/([0-9][0-9][0-9][0-9][0-9]\s*Ft\/1\s*l)|([0-9][0-9][0-9][0-9]\s*Ft\/1\s*l)|([0-9][0-9][0-9]\s*Ft\/1\s*l)|([0-9][0-9]\s*Ft\/1\s*l)|([0-9]\s*Ft\/1\s*l)/';
        $kgPatternShort = '/([0-9][0-9][0-9][0-9][0-9]\s*Ft\/\s*kg)|([0-9][0-9][0-9][0-9]\s*Ft\/\s*kg)|([0-9][0-9][0-9]\s*Ft\/\s*kg)|([0-9][0-9]\s*Ft\/\s*kg)|([0-9]\s*Ft\/\s*kg)/';
        $literPatternShort = '/([0-9][0-9][0-9][0-9][0-9]\s*Ft\/\s*l)|([0-9][0-9][0-9][0-9]\s*Ft\/\s*l)|([0-9][0-9][0-9]\s*Ft\/\s*l)|([0-9][0-9]\s*Ft\/\s*l)|([0-9]\s*Ft\/\s*l)/';
        if (\preg_match($kgPattern, $description)) {
            \preg_match_all($kgPattern, $description, $matches);
            $min = 10000000000000000;
            foreach ($matches as $match) {
                foreach ($match as $currentMatch) {
                    $unitPrice = trim(\preg_replace('/Ft\/1\s*kg/', '', $currentMatch));
                    if ($unitPrice != "" && $unitPrice < $min) {
                        $min = $unitPrice;
                    }
                }
            }
            $productObject->unit = 'kg';
            return $productObject->bestUnitPrice = $min;
        } else if (\preg_match($literPattern, $description)) {
            \preg_match_all($literPattern, $description, $matches);
            $min = 10000000000000000;
            foreach ($matches as $match) {
                foreach ($match as $currentMatch) {
                    $unitPrice = trim(\preg_replace('/Ft\/1\s*l/', '', $currentMatch));
                    if ($unitPrice != "" && $unitPrice < $min) {
                        $min = $unitPrice;
                    }
                }
            }
            $productObject->unit = 'l';
            return $productObject->bestUnitPrice = $min;
        } else if (\preg_match($kgPatternShort, $description)) {
            \preg_match_all($kgPatternShort, $description, $matches);
            $min = 10000000000000000;
            foreach ($matches as $match) {
                foreach ($match as $currentMatch) {
                    $unitPrice = trim(\preg_replace('/Ft\/\s*kg/', '', $currentMatch));
                    if ($unitPrice != "" && $unitPrice < $min) {
                        $min = $unitPrice;
                    }
                }
            }
            $productObject->unit = 'kg';
            return $productObject->bestUnitPrice = $min;
        } else if (\preg_match($literPatternShort, $description)) {
            \preg_match_all($literPatternShort, $description, $matches);
            $min = 10000000000000000;
            foreach ($matches as $match) {
                foreach ($match as $currentMatch) {
                    $unitPrice = trim(\preg_replace('/Ft\/\s*l/', '', $currentMatch));
                    if ($unitPrice != "" && $unitPrice < $min) {
                        $min = $unitPrice;
                    }
                }
            }
            $productObject->unit = 'l';
            return $productObject->bestUnitPrice = $min;
        } else {
            $productObject->unit = 'db';
            return $productObject->bestUnitPrice = $productObject->bestPrice;
        }
    }
    private function handleNormalPriceYellow($product, $productObject)
    {

        $this->handleNormalPrice($product, $productObject);
        return $productObject;
    }
    private function handleTier2LowerThan10($product, $productObject)
    {
        $this->handleBlueCard($product, $productObject);
        return $productObject;
    }
    private function handleDepartmentDiscount($product, $productObject)
    {
        $this->handleBlueCard($product, $productObject);
        return $productObject;
    }
}
