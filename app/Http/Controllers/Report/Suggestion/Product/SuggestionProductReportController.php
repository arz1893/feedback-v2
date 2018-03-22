<?php

namespace App\Http\Controllers\Report\Suggestion\Product;

use App\SuggestionProduct;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuggestionProductReportController extends Controller
{
    public function index() {
        $selectTags = Tag::where('recOwner', Auth::user()->tenantId)->orderBy('name', 'asc')->pluck('name', 'systemId');
        $defaultTags = Tag::where('recOwner', Auth::user()->tenantId)->where('defValue', 1)->orderBy('name', 'asc')->pluck('systemId');
        return view('report.suggestion.product.suggestion_product_report_index', compact('selectTags', 'defaultTags'));
    }

    public function showAllReportYearly() {
        return view('report.suggestion.product.suggestion_product_report_all_yearly');
    }

    public function showDataSuggestionProductYearly(Request $request, $tenantId, $year, $count) {
        $suggestionProducts = SuggestionProduct::where('tenantId', $tenantId)->whereYear('created_at', $year)->orderBy('created_at', 'asc')->get();
        $tempLabels = [];
        $tempDatas = array();

        if(count($suggestionProducts) > 0) {
            foreach ($suggestionProducts as $suggestionProduct) {
                if(!in_array($suggestionProduct->product->name, $tempLabels)) {
                    array_push($tempLabels, $suggestionProduct->product->name);
                    array_push($tempDatas, 0);
                }
            }

            foreach ($suggestionProducts as $suggestionProduct) {
                $index = array_search($suggestionProduct->product->name, $tempLabels);
                $tempDatas[$index] += 1;
            }

            for($i=0;$i<count($tempDatas);$i++) {
                $val = $tempDatas[$i];
                for($j=$i;$j<count($tempDatas);$j++) {
                    if($tempDatas[$j] > $val) {
                        $val = $tempDatas[$j];
                        $tempDatas[$j] = $tempDatas[$i];
                        $tempDatas[$i] = $val;

                        $label = $tempLabels[$j];
                        $tempLabels[$j] = $tempLabels[$i];
                        $tempLabels[$i] = $label;
                    }
                }
            }

            return ['labels' => array_slice($tempLabels, 0, $count), 'data' => array_slice($tempDatas, 0, $count)];
        } else {
            return ['error' => 'not found'];
        }
    }
}
