<?php

if( isset( $_POST[ 'Submit' ] ) ) {
    $target = isset( $_POST[ 'ip' ] ) && is_string( $_POST[ 'ip' ] ) ? trim( $_POST[ 'ip' ] ) : '';

    if( filter_var( $target, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) === false ) {
        $html .= '<pre>ERROR: You have entered an invalid IP.</pre>';
    }
    else {
        $address = escapeshellarg( $target );
        if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
            $cmd = shell_exec( 'ping ' . $address );
        }
        else {
            $cmd = shell_exec( 'ping -c 4 ' . $address );
        }

        $html .= '<pre>' . htmlspecialchars( $cmd ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ) . '</pre>';
    }
}

?>
