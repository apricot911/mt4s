<?php
/**
 * Created by PhpStorm.
 * User: takahiro
 * Date: 14/12/12
 * Time: 11:15
 */

namespace mt4;


class TokenHelper {

    public static function getPublicUrl($compornentName, $openstackObj){
        $catalogs =  $openstackObj['access']['serviceCatalog'];

        $catalog = array_filter($catalogs, function($e) use ($compornentName){
           return $e['name'] ==  $compornentName;
        })[0];
        //var_dump($catalog['endpoints']);
        return $catalog['endpoints'][0]['publicURL'];
    }
} 