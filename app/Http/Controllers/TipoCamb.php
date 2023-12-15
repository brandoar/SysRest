<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;

class TipoCamb extends Controller
{
    //
    public static function tipocamb()
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, "https://www.sbs.gob.pe/app/pp/SISTIP_PORTAL/Paginas/Publicacion/TipoCambioPromedio.aspx");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $html = curl_exec($curl);
        curl_close($curl);

        $html = HtmlDomParser::str_get_html($html);
        //obteniendo fecha de tipo de cambio
        $f_tipc = $html->find('span[id=ctl00_cphContent_lblFecha]', 0);
        $f_tipc = strip_tags(str_replace("Tipo de Cambio al", "", $f_tipc));
       
        if (!empty(trim($f_tipc))) {
            $f_tipc = \DateTime::createFromFormat('d/m/Y', trim($f_tipc));
            $f_tipc = $f_tipc->format("Y-m-d");
        } else {
            $f_tipc = date("Y-m-d");
        }

        //obteniendo tipo de cambio dolares
        $tipcamb = $html->find('tr[id=ctl00_cphContent_rgTipoCambio_ctl00__0]', 0);
        $tipcamb = strip_tags(str_replace("<td", "|<td", $tipcamb));
        $tipcamb = explode("|", $tipcamb);
        $s_dola  = [];
        foreach ($tipcamb as $key => $value) {
            $s_dola[] = str_replace(["Dólar de N.A.", "&nbsp;"], ["1", "1"], trim(strip_tags($value)));
        }
        $s_dola = array_filter($s_dola, "strlen");
        $dolar = [];
        foreach ($s_dola as $key => $val) {
            array_push($dolar, $val);
        }
        //obteniendo tipo de cambio euro
        $tipcamb = $html->find('tr[id=ctl00_cphContent_rgTipoCambio_ctl00__7]', 0);
        $tipcamb = strip_tags(str_replace("<td", "|<td", $tipcamb));
        $tipcamb = explode("|", $tipcamb);
        $s_euro  = [];
        foreach ($tipcamb as $key => $value) {
            $s_euro[] = str_replace(["Euro", "&nbsp;"], ["2", "1"], trim(strip_tags($value)));
        }
        $s_euro = array_filter($s_euro, "strlen");
        $euro = [];
        foreach ($s_euro as $key => $val) {
            array_push($euro, $val);
        }
        
        $tipocamb = []; 
        if (!empty($dolar)) {
            $tipocamb[] = [
                "f_tipc" => $f_tipc,
                "k_mone" => $dolar[0],
                "s_tipc_c" => $dolar[1],
                "s_tipc_v" => $dolar[2],
            ];
        }

        if (!empty($euro)) {
            $tipocamb[] = [
                "f_tipc" => $f_tipc,
                "k_mone" => $euro[0],
                "s_tipc_c" => $euro[1],
                "s_tipc_v" => $euro[2],
            ];
        }

        $resul = [
            "f_tipc" => date("d/m/Y"),
            "k_mone" => 0,
            "s_tipc_c" => 1, 
            "s_tipc_v" => 1, 
        ];

        if (count($tipocamb) > 0) {
            $resul["f_tipc"] = (new \DateTime($tipocamb[0]["f_tipc"]))->format('d/m/Y');
            $resul["s_tipc_c"] = number_format((float)$tipocamb[0]["s_tipc_c"],3,'.','');
            $resul["s_tipc_v"] = number_format((float)$tipocamb[0]["s_tipc_v"],3,'.','');
        }
      
        return $resul;
    }
}
