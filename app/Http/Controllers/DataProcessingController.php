<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FilesystemIterator;
use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;

class DataProcessingController extends Controller
{
	public static function pd()
    {
    	echo '<pre>';

        array_map(function ($x) {
            print_r($x);
        }, func_get_args());

        echo '</pre>';
    }

	public function index()
    {
        $sourcePath = storage_path('app/sample_data');
        $fileSystemIterator = new RecursiveDirectoryIterator($sourcePath);
        $descPath = storage_path('app/sample_result');
        foreach (new RecursiveIteratorIterator($fileSystemIterator) as $file)
        {
        	if ($file->isDir()) { 
        		continue;
    		}
        	$sourceFile = fopen($file->getPathname(), 'r');
        	$sourceData = fread($sourceFile, $file->getSize());
        	fclose($sourceFile);

        	$lines = explode("\r\n", $sourceData);
        	$transformedLines = [];
        	foreach ($lines as $line) {
        		$explodedLine = explode(",", $line);
        		if (count($explodedLine) >= 2) {
        			$transformedLines[$explodedLine[0]] = $explodedLine[1];
        		}
        	}
        	// $transformedLines = $this->editLineMonster($transformedLines);
        	$transformedLines = $this->editLineContainer($transformedLines);
        	$result = [];
        	foreach ($transformedLines as $key => $value) {
        		$result[] = $key . ',' . $value;
        	}
        	$final = implode(",\r\n", $result) . ",\r\n";
        	$descFile = fopen(str_replace('sample_data', 'sample_result', $file->getPathname()), 'w');
        	fwrite($descFile, $final);
        	fclose($descFile);
        }
        echo 'DONE ALL!';
    }

    private function editLineContainer($lineCollection)
    {
    	for ($x = 1; $x <= 6; $x++) {
    		for ($y = 1; $y <= 6; $y++) {
    			$keyName = 'loot' . $x . 'Name' . $y;
    			$keyWeight = 'loot' . $x . 'Weight' . $y;
    			if (isset($lineCollection[$keyName])) {
	    			if (stripos($lineCollection[$keyName], 'unique')) {
	    				$lineCollection[$keyWeight] = $lineCollection[$keyWeight] * 10000;
	    			} else {
	    				continue;
	    			}
    			}
    		}
    	}
    	return $lineCollection;
    }

    private function editLineMonster($lineCollection)
    {
    	$positions = [
    		'Finger1',
    		'Finger2',
    		'Forearm',
    		'Head',
    		'LeftHand',
    		'LowerBody',
    		'Misc1',
    		'Misc2',
    		'Misc3',
    		'RightHand',
    		'Torso'
    	];
    	foreach ($positions as $x) {
    		for ($y = 1; $y <= 6; $y++) {
    			$keyName = 'loot' . $x . 'Item' . $y;
    			$keyWeight = 'chanceToEquip' . $x . 'Item' . $y;
    			if (isset($lineCollection[$keyName])) {
	    			if (stripos($lineCollection[$keyName], 'unique')) {
	    				if (isset($lineCollection[$keyWeight])) {
	    					$lineCollection[$keyWeight] *= 10000;
	    				} else {
	    					$this->pd($lineCollection);
	    					die();
	    				}
	    			} else {
	    				continue;
	    			}
    			}
    		}
    	}
    	return $lineCollection;

    }
}