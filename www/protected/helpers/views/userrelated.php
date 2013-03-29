<div class="list_box">
    <div class="users_list">
        <div class="list_title">
            <?php $current_user_id = $this->user_id; ?>
            <font class="rfblock">Возможно Вы знакомы <?php echo ('('. count($related_count) .')');?></font> <a href="/id<?php echo $current_user_id; ?>/related" class="showAll blue">Весь список</a>
        </div>
        <div class="list_list">
            <?php
            foreach ($related as $item) {
                if (empty($item['avatar']) || !is_file(Yii::app()->request->baseUrl . '/photos/' . $item['avatar'])) {
                    $item['avatar'] = '/images/avatar/default_profile.png';
                }else
                    $item['avatar'] = '/images/80x80/'.$item['avatar'];
                echo '<div class="list_avatar"><a href="/id' . $item['user_id'] . '"><img width="80" src="' . Yii::app()->request->baseUrl . $item['avatar'] .'" alt="" title="'. $item['first_name'] .' '. $item['second_name'] .'" /></a></div>';            }
            ?>
        </div>        
    </div>
</div>


