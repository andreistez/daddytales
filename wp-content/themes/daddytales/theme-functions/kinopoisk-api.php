<?php

/**
 * Sends request and gets response.
 *
 * @param	string	$url		- URL to send request.
 * @return	Object	$response	- JSON Object response.
 */
function dt_get_response_by_url( string $url ): ?Object
{
	if( ! $url ) return null;

	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, [
		'accept: application/json',
		'X-API-KEY: cc9e2d6d-b756-4d5f-9223-e3351808d0ab'
	] );
	$response = curl_exec( $ch );
	curl_close( $ch );
	return json_decode( $response );
}

/**
 * Get cartoon whole info from Kinopoisk API.
 *
 * @param	int		$post_id	- cartoon post ID.
 * @param	int		$cartoon_id	- cartoon ID on kinopoisk.ru.
 */
function dt_get_cartoon_info( int $post_id, int $cartoon_id ){
	if( ! $post_id || ! $cartoon_id ) return null;

	$response = dt_get_response_by_url( 'https://kinopoiskapiunofficial.tech/api/v2.2/films/' . $cartoon_id );

	// Set 'non-static' fields.
	fw_set_db_post_option( $post_id, 'kp_rating', $response->ratingKinopoisk );
	fw_set_db_post_option( $post_id, 'kp_voices', $response->ratingKinopoiskVoteCount );
	fw_set_db_post_option( $post_id, 'imdb_rating', $response->ratingImdb );
	fw_set_db_post_option( $post_id, 'imdb_voices', $response->ratingImdbVoteCount );

	// Check and set 'static' fields if necessary.
	if( ! fw_get_db_post_option( $post_id, 'original_name' ) )
		fw_set_db_post_option( $post_id, 'original_name', $response->nameOriginal );

	if( ! fw_get_db_post_option( $post_id, 'year' ) )
		fw_set_db_post_option( $post_id, 'year', $response->year );

	if( ! fw_get_db_post_option( $post_id, 'length' ) )
		fw_set_db_post_option( $post_id, 'length', $response->filmLength );

	if( ! fw_get_db_post_option( $post_id, 'description' ) )
		fw_set_db_post_option( $post_id, 'description', $response->description );

	if( ! fw_get_db_post_option( $post_id, 'age_limit' ) )
		fw_set_db_post_option( $post_id, 'age_limit', str_replace( 'age', '', $response->ratingAgeLimits ) );

	if( ! fw_get_db_post_option( $post_id, 'countries' ) ){
		$countries = '';
		foreach( $response->countries as $country ){
			$countries .= $country->country . ', ';
		}
		$countries = substr( $countries, 0, -2 );
		fw_set_db_post_option( $post_id, 'countries', $countries );
	}

	if( ! fw_get_db_post_option( $post_id, 'genres' ) ){
		$genres = '';
		foreach( $response->genres as $genre ){
			$genres .= $genre->genre . ', ';
		}
		$genres = substr( $genres, 0, -2 );
		fw_set_db_post_option( $post_id, 'genres', $genres );
	}
}

/**
 * Get cartoon frames from Kinopoisk API.
 *
 * @param	int		$post_id	- cartoon post ID.
 * @param	int		$cartoon_id	- cartoon ID on kinopoisk.ru.
 */
function dt_get_cartoon_frames( int $post_id, int $cartoon_id ){
	if( ! $post_id || ! $cartoon_id ) return null;

	// Do nothing if frames have been already set.
	if( fw_get_db_post_option( $post_id, 'frames' ) ) return;

	// Try new endpoint to get frames (images).
	$response = dt_get_response_by_url( 'https://kinopoiskapiunofficial.tech/api/v2.2/films/' . $cartoon_id . '/images' );

	if( ! empty( $response->items ) ){
		$response = json_encode( $response->items );
	}   else {  // If there are no images - try with another type - SCREENSHOT (STILL by default).
		$response = dt_get_response_by_url( 'https://kinopoiskapiunofficial.tech/api/v2.2/films/' . $cartoon_id . '/images?type=SCREENSHOT' );

		if( ! empty( $response->items ) ){
			$response = json_encode( $response->items );
		}   else {  // If there are no even screenshots - try old API endpoint.
			$response = dt_get_response_by_url( 'https://kinopoiskapiunofficial.tech/api/v2.1/films/' . $cartoon_id . '/frames' );

			if( ! empty( $response->frames ) ) $response = json_encode( $response );
			else $response = '';
		}
	}

	// Write data or empty string to the frames field.
	fw_set_db_post_option( $post_id, 'frames', $response );
}

