<?php
/**
 */
Route::resource('concept', 'ConceptController');

Route::get('toplevel', 'ConceptController@toplevel');
Route::get('flagged', 'ConceptController@flagged');
Route::get('popular', 'ConceptController@popular');
Route::get('shares', 'ConceptController@shares');
Route::get('shared', 'ConceptController@shared');

Route::get('{concept}', function ($concept) {
    return redirect()->route('concept.show', $concept);
});
