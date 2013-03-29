<div class="list_box_other">
    <div class="users_list">
        <div class="users_list_inner">
            <?php
                if (empty($item['avatar']) || !is_file(Yii::app()->request->baseUrl . '/upload/UserProfile/150x150/' . $item['avatar'])) {
                                $item['avatar'] = 'testAvatar.png';
                            }

                $current_loged_user = Yii::app()->user->id;
                $man_id = $item['user_id'];

                $mutual_friends = UserMutualFriends::model()->getMutualFriends($current_loged_user, $man_id);
                $count_mutual_friends = count($mutual_friends);

                $are_friends = UserFriends::model()->areFriends($current_loged_user, $man_id);
                //echo 'words'.$words;
                //$words=array();
                echo '<div class="list_avatar_other"><a href="/id' . $item['user_id'] . '"><img src="'. Yii::app()->request->baseUrl .'/upload/UserProfile/150x150/'. $item['avatar'] .'" alt="" title="'. $item['first_name'] .' '. $item['second_name'] .'" /></a></div>';
                echo '<div class="f_name"><a class="grey" href="/id' . $item['user_id'] . '">' . $this->highlightMatch($words,$item['first_name']) . ' ' . $this->highlightMatch($words,$item['second_name']) . '</a></div>';
                if($man_id===$current_loged_user){
                	echo '<a class="blue_little">Это Вы</a>';
                }elseif($count_mutual_friends!=null){
                    echo '<div class="mutual_friends_link"><a class="blue_little" href="/id' . $current_loged_user . '/mutual/fid' . $man_id . '">Общих друзей: '. $count_mutual_friends .'</a></div>';
                } else {
                    echo '<a class="blue_little">У вас нету общих друзей.</a>';
                }
                if($man_id!==$current_loged_user) {
                	echo '<div class="uf_links_block">';
                	echo '<div class="uf_links"><a class="grey_little" href="#">Написать сообщение</a></div>';
                	echo '<div class="uf_links"><a class="grey_little" href="/id' . $man_id . '/myfriends">Показать друзей</a></div>';

                	if($are_friends == 'friends'){
                    	echo '<div class="uf_links"><a class="grey_little" href="#">Убрать из друзей</a></div>';
                	} elseif ($are_friends == 'myrequest') {
                   	 # code...
                	} elseif ($are_friends == 'request') {
                    	# code...
                	} elseif ($are_friends == 'false') {
                    	echo '<div class="uf_links"><a class="grey_little" href="#">Добавить в друзья</a></div>';
                	}
               		echo '</div>';
               	}

            ?>
        </div>
    </div>
</div>