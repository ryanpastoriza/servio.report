<?php

/**
 * @Author: IanJayBronola
 * @Date:   2019-02-08 16:52:35
 * @Last Modified by:   IanJayBronola
 * @Last Modified time: 2019-02-08 16:57:55
 */
function prep_data($dataSet, $xAxis, $labelField, $sumField, $chartType){

		$takenColors = [];

		$prepVals = ['labels' => [],
					'data' => [],
					'xAxis' => []
				];		
		$labelValues = [];
		$labelValChecker = [];

		$data = [];

		foreach ($dataSet as $key =>  $value) {
			if(!in_array($value->{$labelField},$prepVals['labels'])){
				$prepVals['labels'][] = $value->{$labelField};

				$randR = rand(0,255);
				$randG = rand(0,255);
				$randB = rand(0,255);

				$fill = strtolower($chartType) == 'bar' ?  "rgb({$randR}, {$randG}, {$randB})" : "";
				$borderColor = strtolower($chartType) == 'line' ?  "rgb({$randR}, {$randG}, {$randB})" : "";

				$lVal = (object)['label' => $value->{$labelField},
								'borderColor' => $borderColor,
								'fill' => isset($fill) && $fill ? true : false,
								'backgroundColor' => "rgb({$randR}, {$randG}, {$randB})"
								];

				$prepVals['data'][] = $lVal;


			}
			if(!in_array($value->{$xAxis},$prepVals['xAxis'])){
				$prepVals['xAxis'][] = $value->{$xAxis};
			}
		}


		// foreach ($prepVals['labels'] as $key => $value) {

			
		// }


		foreach ($prepVals['xAxis'] as $key =>  $value) {

				foreach ($prepVals['labels'] as $key2 => $value2) {
					
					foreach ($dataSet as $key3 => $value3) {

						if($value3->{$labelField} == $value2 && $value3->{$xAxis} == $value){
							// $labelValues[$value3->{$labelField}]['data'][] = $value3->{$sumField};
							$prepVals['data'][$key2]->data[] = $value3->{$sumField};
							continue 2;
						}
					}


					$prepVals['data'][$key2]->data[] = 0;
				}
			
		}

		

		return $prepVals;
	}