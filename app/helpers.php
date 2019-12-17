<?php

/**
 * 页面根结点类名
 * @Author   zhanghong(Laifuzi)
 * @DateTime 2019-12-10
 * @return   [type]             [description]
 */
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
