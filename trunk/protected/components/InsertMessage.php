<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

///
function InsertMessage($m) {
    $file = $m->sender->catalog;
    $messageFile = $m->sender->basePath . DIRECTORY_SEPARATOR . $m->language ;
    if(!file_exists($messageFile)){
        mkdir($messageFile, 0755);
    }
    $messageFile .= DIRECTORY_SEPARATOR . $file;
    $data = array();
    if ($m->sender->useMoFile){
        $messageFile.=CGettextMessageSource::MO_FILE_EXT;
        $file = new CGettextMoFile($m->sender->useBigEndian);
        if(is_file($messageFile))
            $data = $file->load($messageFile, $m->category);
    }else{
        $messageFile.=CGettextMessageSource::PO_FILE_EXT;
        $file = new CGettextPoFile();
        if(is_file($messageFile))
            $data = $file->load($messageFile, $m->category);
    }
    $msg = strtoupper($m->language).$m->message;
    try{
        $tmp = file_get_contents("http://translate.yandex.net/api/v1/tr.json/translate?lang=ru-$m->language&text=".urlencode($m->message));
        $tmp = json_decode($tmp);
        if($tmp->code == 200){
            $msg = $tmp->text[0];
        }
    }catch(Exception $e){
        //do nothing
    }
    $data[$m->category.chr(4).$m->message] = $msg;
    $file->save($messageFile, $data);
    $m->message = $msg;
    /*
      $criteria = new CDbCriteria;
      $criteria->condition="`message`='".$m->message."'";
      $c=MessageSource::model()->count($criteria);
      if($c==0) {
      $criteria->condition="`name`='".$m->category."'";
      $c1=MessageCategory::model()->count($criteria);
      if ($c1==0) {
      $c = new MessageCategory();
      $c->name=$m->category;
      $c->title=$m->category;
      $c->save();
      }
      $mes = new MessageSource;
      $mes->message=$m->message;
      $mes->category=$m->category;
      if(!$mes->save()) {
      echo CHtml::errorSummary($mes);
      }else {
      $t = new Message();
      $t->language=$m->language;
      $t->translation=$m->message;
      $t->id=$mes->id;
      $t->save();
      }
      }else {
      $c=MessageSource::model()->find($criteria);
      if(Message::model()->count("`id`='{$c->id}' AND `language`='{$m->language}'")==0) {
      $t = new Message();
      $t->language=$m->language;
      $t->translation=$m->message;
      $t->id=$c->id;
      $t->save();
      }
      } */
}

?>
