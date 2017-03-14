<?php
/**
 * Debugging class, useful for writing different types of data to the log
 */
class Debug {

	/**
	 * objects and arrays are string-ified with print_r for writing to the log.
	 *
	 * @param mixed $value
	 * @return void
	 */
	public static function log_write( $value ){
		if ( is_object( $value ) or is_array( $value ) ){
			error_log( print_r( $value, true ) );
		} else {
			error_log( $value );
		}
	}


	/**
	 * objects and arrays are string-ified with var_dump for writing to the log.
	 *
	 * @param mixed $value
	 * @return void
	 */
	public static function log_dump( $value ){
		if ( is_object( $value ) or is_array( $value ) ){
			ob_start();
			var_dump( $value );
			$dump = ob_get_contents();
			ob_end_clean();

			error_log( $dump );
		} else {
			error_log( $value );
		}
	}

}

