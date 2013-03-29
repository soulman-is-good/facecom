<div class="list_box">
    <div class="users_list">
        <div class="list_title">
            <?php $current_user_id = $this->user_id; ?>
            <font class="rfblock">Возможно Вы знакомы <?php echo ('('. count($related_count) .')');?></font> <a href="/id<?php echo $current_user_id; ?>/related" class="showAll blue">Весь список</a>
        </div>
        <div class="list_list">
            <?php
            foreach ($related as $item) {
                if (empty($item->u_profile->profile->avatar) || !is_file(Yii::app()->request->baseUrl . '/upload/UserProfile/80x80_' . $item['avatar'])) {
                                $item['avatar'] = 'testAvatar.png';
                            }
                echo '<div class="list_avatar"><a href="/id' . $item['user_id'] . '"><img src="' . Yii::app()->request->baseUrl . '/upload/UserProfile/80x80/'. $item['avatar'] .'" alt="" title="'. $item['first_name'] .' '. $item['second_name'] .'" /></a></div>';            }
            ?>
        </div>        
    </div>
</div>


