<?php

namespace Code\Sistema\Helper;

/**
 * Ajusta um campo do tipo Date no momento de salvar o seu conteudo no banco de
 * dados pora o formato AAAA-MM-DD;
 * Ajusta um campo do tipo Date no momento de resgatar o seu conteudo no banco de
 * dados pora o formato DD/MM/AAAA
 *
 * @author eduardo
 */
class DateHelper {
    
    static public function getDate($date){
        if($date != ''){
            return (substr($date,8,2).'/'.substr($date,4,2).'/'.  substr($date,0,4));
        }        
        return null;
    }

    //DD/MM/AAAA to AAAA-MM-DD
    static public function setDate($date){
        if($date != ''){
            return (substr($date,6,4).'-'.substr($date,3,2).'-'.  substr($date,0,2));
        }        
        return null;
    }
}