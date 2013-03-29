<div class="list_box_other">
    <div class="users_list">
        <div class="users_list_inner">
            <?php
                if (empty($item['avatar']) || !is_file(Yii::app()->request->baseUrl . '/photos/' . $item['avatar'])) {
                    $item['avatar'] = '/images/avatar/default_profile.png';
                }else
                    $item['avatar'] = '/images/small/'.$item['avatar'];
                echo '<div class="list_avatar_other"><a href="/id' . $item['user_id'] . '"><img width="150" src="' . Yii::app()->request->baseUrl . $item['avatar'] .'" alt="" title="'. $item['first_name'] .' '. $item['second_name'] .'" /></a></div>';
                echo '<div class="f_name"><a class="grey" href="/id' . $item['user_id'] . '">' . $item['first_name'] . ' ' . $item['second_name'] . '</a></div>'
                
            ?>
        </div>        
    </div>
</div>


