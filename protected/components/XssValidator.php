<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XssValidator
 *
 * @author maxim
 */
class XssValidator extends CValidator {
    
    protected function validateAttribute($object, $attribute) {
        $data = $object->$attribute;
        $data = preg_replace('#([a-z]*)[x00-x20]*=[x00-x20]*([`\'"]*)[x00-x20]*j[x00-x20]*a[x00-x20]*v[x00-x20]*a[x00-x20]*s[x00-x20]*c[x00-x20]*r[x00-x20]*i[x00-x20]*p[x00-x20]*t[x00-x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[x00-x20]*=([\'"]*)[x00-x20]*v[x00-x20]*b[x00-x20]*s[x00-x20]*c[x00-x20]*r[x00-x20]*i[x00-x20]*p[x00-x20]*t[x00-x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[x00-x20]*=([\'"]*)[x00-x20]*-moz-​binding[x00-x20]*:#u', '$1=$2nomozbinding...', $data);
        // Only works in IE: <span style="width: exp​ression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[x00-x20]*=[x00-x20]*[`\'"]*.*?exp​ression[x00-x20]*([^>]*+>)#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[x00-x20]*=[x00-x20]*[`\'"]*.*?behaviour[x00-x20]*([^>]*+>)#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[x00-x20]*=[x00-x20]*[`\'"]*.*?s[x00-x20]*c[x00-x20]*r[x00-x20]*i[x00-x20]*p[x00-x20]*t[x00-x20]*:*[^>]*+>#iu', '$1>', $data);
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*w+:w[^>]*+>#i', '', $data);
        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);
        $object->$attribute = $data;
        return true;        
    }
}

?>
