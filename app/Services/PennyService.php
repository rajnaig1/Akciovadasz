<?php

namespace App\Services;

use App\Repositories\Penny_General_Repository;
use App\Outside_Resources\OutsideResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PennyService
{
    protected $outsideResponse;
    protected $pennyGeneral;
    public function __construct(OutsideResponse $outsideResponse, Penny_General_Repository $pennyGeneral)
    {
        $this->outsideResponse = $outsideResponse;
        $this->pennyGeneral = $pennyGeneral;
    }
    public function upsertTotalProductNumber()
    {
        $total = $this->pennyGeneral->getTotal();
        if (isset($total[0]->_id) && null != $total[0]->_id) {
            return $this->pennyGeneral->updateTotal($total[0], $this->outsideResponse->pennyTotal());
        } else {
            return $this->pennyGeneral->createTotal($this->outsideResponse->pennyTotal());
        }
    }
    public function getTotal()
    {
        $total = $this->pennyGeneral->getTotal();
        return $total[0]->Total;
    }
    public function storeAllProducts()
    {
        $this->pennyGeneral->wipeShoppingCarts();
        $this->pennyGeneral->wipeProducts();
        $this->batchPennyProductCalls();
        return 'done';
    }
    public function batchPennyProductCalls100($total)
    {
        $callSize = 100;
        $startsFrom = 0;
        $remaining = $total % $callSize;
        $stepsize = ($total - $remaining) / $callSize;
        $this->batchProcessor($startsFrom, $callSize, $stepsize);
        return ['Remaining100' => $remaining, 'stepSize' => $stepsize, 'startsFrom' => $startsFrom];
    }
    public function batchPennyProductCalls10($total, $remaining100Array)
    {
        $remaining100 = $remaining100Array['Remaining100'];
        $callSize = 10;
        $remaining = $total % $callSize;
        $totalstepsize = ($total - $remaining) / $callSize;
        $stepSize = ($remaining100 - $remaining) / $callSize;
        $startFrom = $totalstepsize - $stepSize;
        $this->batchProcessor($startFrom, $callSize, $totalstepsize);
        return ['Remaining10' => $remaining, 'stepSize' => $totalstepsize, 'startsFrom' => $startFrom];
    }
    public function batchPennyProductCalls1($total, $remaining10Array)
    {
        $remaining10 = $remaining10Array['Remaining10'];
        $callSize = 1;
        $stepsize = $total;
        $startFrom = $total - $remaining10;
        $this->batchProcessor($startFrom, $callSize, $stepsize);
        return  ['Remaining10' => 0, 'stepSize' => $stepsize, 'startsFrom' => $startFrom];
    }
    private function batchProcessor($startsFrom, $callSize, $stepsize)
    {
        for ($i = $startsFrom; $i < $stepsize; $i++) {
            $this->pennyGeneral->storeAllProducts($this->outsideResponse->pennyAllProducts($i, $callSize));
        }
    }
    public function batchPennyProductCalls()
    {
        $total = $this->getTotal();
        $remaining = $this->batchPennyProductCalls100($total);
        $remaining = $this->batchPennyProductCalls10($total, $remaining);
        $this->batchPennyProductCalls1($total, $remaining);
    }
    public function getAllStoredPennyProducts($paginator, $orderBy, $sortDirection, $query)
    {
        if ($orderBy == null) {
            $pennyProducts = $this->pennyGeneral->getAllProducts($paginator);
            return $pennyProducts;
        } else {
            if ($query == '' || $query == null) {
                $query = '%';
            } else {
                str_replace(' ', '%', $query);
                $query = '%' . $query . '%';
            }
            $pennyProducts = $this->pennyGeneral->getAllProductsOrdered($paginator, $orderBy, $sortDirection, $query);
            return $pennyProducts;
        }
    }
    public function validateUpdatePennyProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'unitLong' => ['required'],
            'unitPrice' => ['required', 'numeric'],
            'unitShort' => ['required'],
            'priceScore' => ['required', 'numeric'],
            'volumeLabelLong' => ['required'],
            'Category' => ['required'],
            'validityStart' => ['required', 'date'],
            'validityEnd' => ['required', 'date'],
            'isPublished' => ['required', 'regex:/0|1/'],
            'weight' => ['required', 'numeric'],
            'productMarketing' => [],
            'images' => []
        ]);
        return $validator;
    }
    public function updatePennyProduct($id, $validator)
    {
        $this->pennyGeneral->updatePennyProduct($id, $validator->validate());
    }
    public function deleteProduct($id)
    {
        $this->pennyGeneral->deleteShoppingCarts($id);
        $this->pennyGeneral->deletePennyProduct($id);
    }
    public function checkHealth()
    {
        return 'Service alive';
    }
}
