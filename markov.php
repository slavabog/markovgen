<?php

function generate_markov_table($text, $order) {
    
    // walk through the text and make the index table for words
    $wordsTable = explode(' ',trim($text)); 
	$table = array();
	$tableKeys = array();
	$i = 0;
	
	foreach($wordsTable as $key=>$word){
		$nextWord = "";
		for($j = 0; $j < $order; $j++){
			if($key + $j + 1 != sizeof($wordsTable) - 1)
				$nextWord .= " " . $wordsTable[$key + $j + 1];
		}
		if (!isset($table[$word . $nextWord])){
			$table[$word . $nextWord] = array();
		};
	}
	
    $tableLength = sizeof($wordsTable);
	
    // walk the array again and count the numbers
	for($i = 0; $i < $tableLength - 1; $i++){
		$word_index = $wordsTable[$i];		
		$word_count = $wordsTable[$i+1];
		if (isset($table[$word_index][$word_count])) {
			$table[$word_index][$word_count] += 1;
		} else {
			$table[$word_index][$word_count] = 1;	  
		}
	}
	
    return $table;
}

function sentenceBegin($str){
	return $str == ucfirst($str);
}

function generate_markov_text($length, $table) {
    // get first word
	do{
		$word = array_rand($table);
	}while(!sentenceBegin($word));
		
    $o = $word;

    while(strlen($o) < $length){
        $newword = return_weighted_word($table[$word]);            
        
        if ($newword) {
            $word = $newword;
            $o .= " " . $newword;
        } else {       
            do{
				$word = array_rand($table);
			}while(!sentenceBegin($word));
        }
    }
    
	
    return $o;
}
    

function return_weighted_word($array) {
    if (!$array) return false;
    
    $total = array_sum($array);
    $rand  = mt_rand(1, $total);
    foreach ($array as $item => $weight) {
        if ($rand <= $weight) return $item;
        $rand -= $weight;
    }
}
?>