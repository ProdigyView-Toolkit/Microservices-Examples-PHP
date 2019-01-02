<?php

class SearchTerms {

  public function tokenize($terms) {

    $terms = str_replace(' ', ',', $terms);
    $terms = str_replace('|', '', $terms);
    $terms = str_replace('&', '', $terms);
    $terms = str_replace('\'', '', $terms);
    $terms = Database::makeSafe($terms);
    $terms_array = explode(',', $terms);
    $terms = '';
    $join = '';
    $first = true;

    foreach ($terms_array as $term) {
      if (!empty($term)) {
        if ($first == false) {
          $terms .= '&';
        }
        $terms .= $term;
        $first = false;
      }
    }//end for each;
    
    return $terms;

  }

}