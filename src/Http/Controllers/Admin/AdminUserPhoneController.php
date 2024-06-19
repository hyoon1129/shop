<?php

namespace Jiny\Shop\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminUserPhoneController extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        $this->actions['table'] = "user_phone"; // 테이블 정보

        $this->actions['view_list'] = "jiny-shop::admin.user_phone.list";
        $this->actions['view_form'] = "jiny-shop::admin.user_phone.form";

    }

    // 신규 데이터 DB 삽입전에 호출됩니다.
    public function hookStoring($wire,$form)
    {
        $user = DB::table('users')->where('email',$form['email'])->first();
        if($user) {
            $form['user_id'] = $user->id;
            return $form; // 사전 처리한 데이터를 반환합니다.
        }
    }



}
