<?php

  // Constantes para definir los estándares

  define('VALIDATE_NUM',          '0-9');
  define('VALIDATE_SPACE',        '\s');
  define('VALIDATE_ALPHA_LOWER',  'a-z');
  define('VALIDATE_ALPHA_UPPER',  'A-Z');
  define('VALIDATE_ALPHA',        VALIDATE_ALPHA_LOWER . VALIDATE_ALPHA_UPPER);
  define('VALIDATE_EALPHA_LOWER', VALIDATE_ALPHA_LOWER . '???????????????????????????');
  define('VALIDATE_EALPHA_UPPER', VALIDATE_ALPHA_UPPER . '???????????????????????????');
  define('VALIDATE_EALPHA',       VALIDATE_EALPHA_LOWER . VALIDATE_EALPHA_UPPER);
  define('VALIDATE_PUNCTUATION',  VALIDATE_SPACE . '\.,;\:&"\'\?\!\(\)');
  define('VALIDATE_NAME',         VALIDATE_EALPHA . VALIDATE_SPACE . "'");
  define('VALIDATE_STREET',       VALIDATE_NAME . "/\\??\.");


  class Valida
  {
    var $validacion = Array();

    function ponerValidacion($campo, $mensaje) // Esta función nos ayuda a mandar los mensajes en caso de ser NULL
    {
      $this->validacion[$campo] = $mensaje;
    }

  	function obtenerValidacion()
    {
  		return $this->validacion;
  	}

  	function formularioVacio($campos)
    {
  		$vacio = true;

  		if(count($campos) > 0)
      {
  			foreach($campos as $campo)
        {
  				if(str_replace(" ", "", $_POST[$campo]) != "")
  					$vacio = false;
  			}
  			if($vacio)
  			$this->ponerValidacion('Vacio', 'Debe de establecer por lo menos un criterio de consulta.');
  		}
  		return $vacio;
  	}

	   function formularioCamposObligatorios($campos)
     {
       $lleno = false;

       if(count($campos) > 0)
       {
         $lleno = true;

         foreach($campos as $campo)
         {
           if(str_replace(" ", "", $_POST[$campo]) == "")
           $lleno = false;
         }
         if(!$lleno)
         $this->ponerValidacion('Lleno', 'Debe de llenar todos los campos obligatorios.');
       }

       return $lleno;
	    }

	    function formularioCamposIncluyentes($campos, $mensaje)
      {
        $lleno = false;

        if(count($campos) > 0)
        {
          foreach($campos as $campo)
          {
            if(str_replace(" ", "", $_POST[$campo]) != "")
            $lleno = true;
          }
          if(!$lleno)
          $this->ponerValidacion('Incluyente', $mensaje);
        }

        return $lleno;
      }

    /**
     * Valida una cadena usando el formato dado 'format'
     *
     * @param string    $cadena     Cadena a validar.
     * @param array     $options    Opciones del array donde:
     *                              'format' es el formato de la cadena
     *                                  Ejemplo: VALIDATE_NUM . VALIDATE_ALPHA (ver constantes)
     *                              'min_length' minimo de longitud
     *                              'max_length' maximo de longitud
     * @param string	$campo		Nombre de la etiqueta que describe el campo en el formulario
     * 								se ocupa como indice en el arreglo asociativo de errores.
     * @param string	$mensaje	Mensaje que se desea poner en caso de error
     * @access public
     */

    function cadena($cadena, $options, $campo, $mensaje) {
    	$cadena = str_replace(" ", "", $cadena);
        $format = null;
        $min_length = $max_length = 0;
        if (is_array($options)) {
            extract($options); // Extrae variables
        }
        if ($format && !preg_match("|^[$format]*\$|s", $cadena)) {
            $this->ponerValidacion($campo, $mensaje);
        }
        if ($min_length && (strlen($cadena) < $min_length)) {
            $this->ponerValidacion($campo, 'El '.$campo.' no cumple con la longitud m&iacute;nima permitida.');
        }
        if ($max_length && (strlen($cadena) > $max_length)) {
            $this->ponerValidacion($campo, 'El '.$campo.' no cumple con la longitud m&aacute;xima permitida.');
        }
    }

	function numeroEntero($cadena, $longitud, $campo, $mensaje) {
		if ($longitud != "") {
			if(strlen($cadena) != $longitud) {
				$this->ponerValidacion($campo, 'El '.$campo.' no tiene la longitud adecuada('.$longitud.').');
			}
			else {
				if(!preg_match('/(['.VALIDATE_NUM.']{'.$longitud.'})/', $cadena))
				$this->ponerValidacion($campo, $mensaje);
			}
		}
		else {
			if(!preg_match('/(['.VALIDATE_NUM.'])/', $cadena))
			$this->ponerValidacion($campo, $mensaje);
		}
	}

    /**
     * Validate a number
     *
     * @param string    $number     Number to validate
     * @param array     $options    array where:
     *                              'decimal'   is the decimal char or false when decimal not allowed
     *                                          i.e. ',.' to allow both ',' and '.'
     *                              'dec_prec'  Number of allowed decimals
     *                              'min'       minimum value
     *                              'max'       maximum value
     *
     * @return boolean true if valid number, false if not
     *
     * @access public
     */
    function numero($number, $options = array(), $campo, $mensaje) {
        $decimal = $dec_prec = $min = $max = null;
        if (is_array($options)) {
            extract($options);
        }

        $dec_prec   = $dec_prec ? "{1,$dec_prec}" : '+';
        $dec_regex  = $decimal  ? "[$decimal][0-9]$dec_prec" : '';

        if (!preg_match("|^[-+]?\s*[0-9]+($dec_regex)?\$|", $number)) {
			$this->ponerValidacion($campo, 'El '.$campo.' no es n&uacute;mero v&aacute;lido.');
        }

        if ($decimal != '.') {
            $number = strtr($number, $decimal, '.');
        }

        $number = (float)str_replace(' ', '', $number);
        if ($min !== null && $min > $number) {
			$this->ponerValidacion($campo, 'El '.$campo.' no tiene la longitud adecuada('.$longitud.').');
        }

        if ($max !== null && $max < $number) {
			$this->ponerValidacion($campo, 'El '.$campo.' no tiene la longitud adecuada('.$longitud.').');        }
        return true;
    }

	// Se usa por ejemplo para validar el domicilio.
    function alphaNumerico($cadena, $campo, $mensaje) {
        if(!preg_match('/^[[:alnum:]\ \.\#\(\)\-]+$/', $cadena))
			$this->ponerValidacion($campo, $mensaje);
    }

	function rfc($cadena, $tipoPersona, $campo) {
    	$cadena = str_replace(" ", "", $cadena);
		if($tipoPersona=='F') {		// Fisica
			if(strlen($cadena) == 10) {
				if(!preg_match('/(['.VALIDATE_ALPHA_UPPER.']{4})(['.VALIDATE_NUM.']{6})/', $cadena))
					$this->ponerValidacion($campo, 'El '.$campo.' no tiene el formato correcto: XXXXAAMMDDHHH, XXXX iniciales de la persona, AA a&ntilde;o, MM mes, DD dia.');
			}
			if(strlen($cadena) == 13) {
				if(!preg_match('/(['.VALIDATE_ALPHA_UPPER.']{4})(['.VALIDATE_NUM.']{6})([A-Z_0-9]{3})/', $cadena))
					$this->ponerValidacion($campo, 'El '.$campo.' no tiene el formato correcto: XXXXAAMMDDHHH, XXXX iniciales de la persona, AA a&ntilde;o, MM mes, DD dia y HHH para la homoclave.');
			}
			if(strlen($cadena) != 10 && strlen($cadena) != 13) {
				$this->ponerValidacion($campo, 'El '.$campo.' no tiene el formato correcto: XXXXAAMMDDHHH, XXXX iniciales de la persona, AA a&ntilde;o, MM mes, DD dia y (opcional) HHH para la homoclave.');
			}
		}	// Fisica
		if($tipoPersona=='M') {		// Moral
			if(strlen($cadena) == 12) {
				if(!preg_match('/(['.VALIDATE_ALPHA_UPPER.']{3})(['.VALIDATE_NUM.']{6})([A-Z_0-9]{3})/', $cadena))
					$this->ponerValidacion($campo, $mensaje);
			} else {
				$this->ponerValidacion($campo, 'El '.$campo.' no tiene el formato correcto: XXXAAMMDDHHH, XXX iniciales de la empresa, AA a&ntilde;o, MM mes, DD dia y HHH para la homoclave.');
			}
		} // Moral
    }

    function curp($cadena, $campo) {
    	$cadena = str_replace(" ", "", $cadena);
		if(strlen($cadena) != 18)
			$this->ponerValidacion($campo, 'El campo '.$campo.' no tiene el formato correcto: XXXXAAMMDDSEECCCLN, XXXX iniciales de la persona, AA a&ntilde;o, MM mes, DD dia, S sexo, EE entidad federativa, CCC segundas consonantes internas del nombre completo, L caracter o n&uacute;mero y un N n&uacute;mero.');
		else {
			if(!preg_match('/(['.VALIDATE_ALPHA_UPPER.']{4})(['.VALIDATE_NUM.']{6})(['.VALIDATE_ALPHA_UPPER.']{6})([A-Z_0-9]{1})(['.VALIDATE_NUM.']{1})/', $cadena))
				$this->ponerValidacion($campo, 'El campo '.$campo.' no tiene el formato correcto: XXXXAAMMDDSEECCCLN, XXXX iniciales de la persona, AA a&ntilde;o, MM mes, DD dia, S sexo, EE entidad federativa, CCC segundas consonantes internas del nombre completo, L caracter o n&uacute;mero y un N n&uacute;mero.');
		}
    }

    /**
     * Valida un email
     *
     * @param string $email email to validate
     * @param mixed boolean (BC) $check_domain   Check or not if the domain exists
     *              array $options associative array of options
     *              'check_domain' boolean Check or not if the domain exists
     *              'use_rfc822' boolean Apply the full RFC822 grammar
     *
     * @return boolean true if valid email, false if not
     *
     * @access public
     */
    function email($email, $options = null, $campo) {
        $check_domain = false;
        $use_rfc822 = false;
        if (is_bool($options)) {
            $check_domain = $options;
        } elseif (is_array($options)) {
            extract($options);
        }

        // the base regexp for address
        $regex = '&^(?:                                               # recipient:
         ("\s*(?:[^"\f\n\r\t\v\b\s]+\s*)+")|                          #1 quoted name
         ([-\w!\#\$%\&\'*+~/^`|{}]+(?:\.[-\w!\#\$%\&\'*+~/^`|{}]+)*)) #2 OR dot-atom
         @(((\[)?                     #3 domain, 4 as IPv4, 5 optionally bracketed
         (?:(?:(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:[0-1]?[0-9]?[0-9]))\.){3}
               (?:(?:25[0-5])|(?:2[0-4][0-9])|(?:[0-1]?[0-9]?[0-9]))))(?(5)\])|
         ((?:[a-z0-9](?:[-a-z0-9]*[a-z0-9])?\.)*[a-z0-9](?:[-a-z0-9]*[a-z0-9])?)  #6 domain as hostname
         \.((?:([^- ])[-a-z]*[-a-z])?)) #7 TLD
         $&xi';

        if ($use_rfc822? Valida::__emailRFC822($email, $options) :
            preg_match($regex, $email)) {
            if ($check_domain && function_exists('checkdnsrr')) {
                list (, $domain)  = explode('@', $email);
                if (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A')) {
                    return true;
                }
                $this->ponerValidacion($campo, 'El campo '.$campo.' no tiene el formato correcto.');
                return false;
            }
            return true;
        }
        $this->ponerValidacion($campo, 'El campo '.$campo.' no tiene el formato correcto.');
        return false;
    }

}

?>
