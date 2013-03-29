<div class="list_box_other">
    <div class="users_list">
        <div class="users_list_inner">
            <?php
                if (empty($item->u_profile->profile->avatar) || !is_file(Yii::app()->request->baseUrl . '/upload/UserProfile/150x150/' . $item['avatar'])) {
                                $item['avatar'] = '150x150_testAvatar.png';
                            }
                echo '<div class="list_avatar_other"><a href="/id' . $item['user_id'] . '"><img src="' . Yii::app()->request->baseUrl . '/upload/UserProfile/150x150/'. $item['avatar'] .'" alt="" title="'. $item['first_name'] .' '. $item['second_name'] .'" /></a></div>';
                echo '<div class="f_name"><a class="grey" href="/id' . $item['user_id'] . '">' . $item['first_name'] . ' ' . $item['second_name'] . '</a></div>'
                
            ?>
        </div>        
    </div>
</div>


