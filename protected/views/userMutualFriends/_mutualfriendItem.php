<div class="list_box_other">
    <div class="users_list">
        <div class="users_list_inner">
            <?php
                if (empty($item['avatar']) || !is_file(Yii::app()->request->baseUrl . '/upload/UserProfile/150x150/' . $item['avatar'])) {
                                $item['avatar'] = '150x150_testAvatar.png';
                            }

                $current_loged_user = Yii::app()->user->id;
                $current_page_id = $_GET['id'];

                echo '<div class="list_avatar_other"><a href="/id' . $item['user_id'] . '"><img src="'. Yii::app()->request->baseUrl .'/upload/UserProfile/150x150/'. $item['avatar'] .'" alt="" title="'. $item['first_name'] .' '. $item['second_name'] .'" /></a></div>';
                echo '<div class="f_name"><a class="grey" href="/id' . $item['user_id'] . '">' . $item['first_name'] . ' ' . $item['second_name'] . '</a></div>';
                
                echo '<br>';
                echo '<div class="uf_links_block">';
                echo '<div class="uf_links"><a class="grey_little" href="#">Написать сообщение</a></div>';
                echo '<div class="uf_links"><a class="grey_little" href="/id' . $item['user_id'] . '/myfriends">Показать друзей</a></div>';
                echo '<div class="uf_links"><a class="grey_little" href="#">Удалить из друзей</a></div>';
                echo '</div>';
                
            ?>
        </div>
    </div>
</div>

