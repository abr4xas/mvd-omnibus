<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2017 Angel Cruz <me@abr4xas.org>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the “Software”), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author Angel Cruz <me@abr4xas.org>
 * @license MIT License
 * @copyright 2017 Angel Cruz
 */

namespace Omnibus;

use DateTime;
use DateTimeZone;

class Omnibus
{
    /**
     *  URL de API
     *  @var API EndPoint
     */
    const BASE_PATH = 'http://www.montevideo.gub.uy/transporteRestProd/';

    /**
     *  Function getRutas
     *  Retorna listado de ómnibus
     *  @param init $nParada
     *  @return array
     */
    public static function getRutas($nParada)
    {
        $url = 'pasadas/'.$nParada.'/'.self::getDia().'/'.self::getTime();

        return self::getData($url);
    }

    /**
     *  Function getParadas
     *  Recibe un código de parada de ómnibus, 
     *  y devuelve la descripcion de la parada 
     *  y la lista de líneas que pasan por ella.
     *  @param init $nParada
     *  @return array
     */
    public static function getParadas($nParada)
    {
        $url = 'lineas/'.$nParada;

        return self::getData($url);
    }

    /**
     *  Function getParadasDiaLinea
     *  Recibe un código de parada de ómnibus, 
     *  un tipo de día, y un código de línea de ómnibus, 
     *  y devuelve la lista de todas las pasadas en el día, para esa línea.
     *  @param init $nParada
     *  @param init $nParada
     *  @return array
     */
    public static function getParadasDiaLinea($nParada, $nLinea)
    {
        $url = 'lineas/'.$nParada.'/'.self::getDia().'/'.$nParada.'/'.$nLinea;

        return self::getData($url);
    }

    /**
     *  Function getParadasDiaLineaHora
     *  Recibe un código de parada de ómnibus, 
     *  un tipo de día, y un código de línea de ómnibus, 
     *  y devuelve las siguientes diez pasadas luego de 
     *  la hora especificada, de la línea especificada
     *  @param init $nParada
     *  @param init $nParada
     *  @return array
     */
    public static function getParadasDiaLineaHora($nParada, $nLinea)
    {
        $url = 'lineas/'.$nParada.'/'.self::getDia().'/'.$nParada.'/'.$nLinea.'/'.self::getTime();

        return self::getData($url);
    }

    /**
     *  Function getDia
     *  Retorna el dia
     *  @return string
     */
    private static function getDia()
    {
        if (self::getTime(['f' => 'D'] == 'Sun')) {
            $dia = 'DOMINGO';
        }

        if (self::getTime(['f' => 'D'] == 'Sat')) {
            $dia = 'SABADO';
        }

        if (self::getTime(['f' => 'D'] != 'Sat' || self::getTime(['f' => 'D'] != 'Sun'))) {
            $dia = 'HABIL';
        }

        return $dia;
    }

    /**
     *  Function getData
     *  Retorna respuesta del EndPoint
     *  @param string $url
     *  @return array
     */
    private static function getData($url)
    {

        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_URL             => self::BASE_PATH . $url,
            CURLOPT_USERAGENT       => 'OmniBot v0.1'
        ]);
        
        $resp = curl_exec($curl);
        
        curl_close($curl);

        return $resp;      
    }

    /**
     *  Function getTime
     *  Retorna formato de fecha y hora
     *  @param array $options
     *  @return string
     */
    private static function getTime($options = [])
    {
        $format  = isset($options['f']) ? $options['f'] : 'H:i';

        $dayTime = new DateTime('now', new DateTimeZone('America/Montevideo'));

        return $dayTime->format($format);
    }
    
}
