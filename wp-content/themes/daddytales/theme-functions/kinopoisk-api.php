<?php

/**
 * Get cartoon whole info from Kinopoisk API.
 *
 * @param	int		$post_id	- cartoon post ID.
 * @param	int		$cartoon_id	- cartoon ID on kinopoisk.ru.
 */
function dt_get_cartoon_info( int $post_id, int $cartoon_id ){
	if( ! is_int( $post_id ) || ! is_int( $cartoon_id ) ) return null;

	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, "https://kinopoiskapiunofficial.tech/api/v2.2/films/" . $cartoon_id );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, [
		'accept: application/json',
		'X-API-KEY: cc9e2d6d-b756-4d5f-9223-e3351808d0ab'
	] );
	$response = curl_exec( $ch );
	curl_close( $ch );
	$response = json_decode( $response );

	// Set 'non-static' fields.
	fw_set_db_post_option( $post_id, 'kp_rating', $response->ratingKinopoisk );
	fw_set_db_post_option( $post_id, 'kp_voices', $response->ratingKinopoiskVoteCount );
	fw_set_db_post_option( $post_id, 'imdb_rating', $response->ratingImdb );
	fw_set_db_post_option( $post_id, 'imdb_voices', $response->ratingImdbVoteCount );

	// Check and set 'static' fields if necessary.
	if( ! fw_get_db_post_option( $post_id, 'original_name'  ) )
		fw_set_db_post_option( $post_id, 'original_name', $response->nameOriginal );

	if( ! fw_get_db_post_option( $post_id, 'year'  ) )
		fw_set_db_post_option( $post_id, 'year', $response->year );

	if( ! fw_get_db_post_option( $post_id, 'length'  ) )
		fw_set_db_post_option( $post_id, 'length', $response->filmLength );

	if( ! fw_get_db_post_option( $post_id, 'description'  ) )
		fw_set_db_post_option( $post_id, 'description', $response->description );

	if( ! fw_get_db_post_option( $post_id, 'age_limit'  ) )
		fw_set_db_post_option( $post_id, 'age_limit', str_replace( 'age', '', $response->ratingAgeLimits ) );

	if( ! fw_get_db_post_option( $post_id, 'countries'  ) ){
		$countries = '';
		foreach( $response->countries as $country ){
			$countries .= $country->country . ', ';
		}
		$countries = substr( $countries, 0, -2 );
		fw_set_db_post_option( $post_id, 'countries', $countries );
	}

	if( ! fw_get_db_post_option( $post_id, 'genres'  ) ){
		$genres = '';
		foreach( $response->genres as $genre ){
			$genres .= $genre->genre . ', ';
		}
		$genres = substr( $genres, 0, -2 );
		fw_set_db_post_option( $post_id, 'genres', $genres );
	}
}

