<?php
//? Clase verificada 04/07/2021
//?No requiere comunicación con la BD
require('../recursos/fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {

        //? AddLink
        /*
        Funciones: Crea una referencia interna a cualquier sitio
        Parametros: No tiene
        Descripción:
        -------------------------------------------------------------*/
        $this->AddLink();

        //? Image
        /*
        Funciones: Imprime una imagen en el archivo
        Parametros: Obligatorios
        Descripción:
        -------------------------------------------------------------
        file: (Ruta de la imagen)
        x: (Espacio entre el borde izquierdo y la imagen) - null
        y: (Espacio entre el cabezara y la imagen) - null
        w: (Ancho de la imagen en la pagina)
            Si el valor es positivo, éste será la altura en la unidad de medida definida por el usuario.
            Si el valor es negativo, el valor absoluto será la resolución vertical en ppp.
            Si no se especifica o es cero, se calcula automáticamente
        h: (Alto de la imagen)
        type: (Se puede deducir según su extensión)
        link: Identificador de AddLink
        -------------------------------------------------------------*/
        $this->Image("../recursos/imagenes/fca.png", 20, 10, 20, 20, "", "");
        $this->Image("../recursos/imagenes/unam.png", 170, 10, 20, 20, "", "");
        $this->SetFont("Times", "B", 14);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode("Facultad de Contaduría y Administración"), 0, 1, "C");

        $this->SetFont("Times", "", 13);
        $this->Cell(80);
        $this->Cell(30, 10, utf8_decode("Universidad Nacional Autónoma de México"), 0, 1, "C");
        $this->Ln(10);
    }

    function Footer()
    {

        //? SetY
        /*
        Funciones: Establece la ordenada y de forma opcional mueve la abscisa al margen izquierdo.
                   Si el valor pasado es negativo, esta es relativa a la parte inferior de la página.
        Parametros: Obligatorios
        Descripción:
        ----------------------------------------------------------------
        y: El valor de la ordenada (vertical) si es negativo se centra.

        ----------------------------------------------------------------*/
        $this->SetY(-18);

        $this->SetFont("Times", "", 13);
        $this->Cell(0, 10, utf8_decode('Página '.$this->PageNo().' de {nb}'), 0, 0, 'C');
    }
}
