<?php

$router->get('/', ["as"=>"home", "uses"=>"WebsiteController@index"]);
$router->get('/contact_us', ["as"=>"contact", "uses"=>"WebsiteController@contact"]);
$router->get('/business_plan', ["as"=>"business_plan", "uses"=>"WebsiteController@business"]);
$router->get('/success_registration', ["as"=>"success_reg", "uses"=>"WebsiteController@success_reg"]);
$router->get('/product', ["as"=>"product", "uses"=>"WebsiteController@product"]);
$router->get('/about_us', ["as"=>"about_us", "uses"=>"WebsiteController@about_us"]);

$router->get('/login', ['as'=>"login", 'uses'=>"WebsiteController@login"]);
$router->post('/login', "WebsiteController@post_login");
$router->get('/forgot_password', ['as'=>"fpassword", 'uses'=>"WebsiteController@fpassword"]);
$router->post('/forgot_password', "WebsiteController@post_fpassword");
$router->get('/register', ['as'=>"register", 'uses'=>"WebsiteController@register"]);
$router->post('/register', "WebsiteController@post_register");
$router->post('/get/member_name', ['as'=>"member_name", 'uses'=>"WebsiteController@member_name"]);

$router->group(['middleware' => 'member', 'prefix' => 'member'], function () use ($router) {
    $router->get('/dashboard', ['as'=>"member.dashboard", 'uses'=>"MemberController@dashboard"]);

    $router->get('/account/statement', ['as'=>"member.account.statement", 'uses'=>"MemberController@account_statement"]);
    $router->post('/account/statement', "MemberController@account_statement");
    $router->get('/account/payout', ['as'=>"member.account.payout", 'uses'=>"MemberController@account_payout"]);
    $router->get('/account/fundtransfer', ['as'=>"member.account.fundtransfer", 'uses'=>"MemberController@account_fundtransfer"]);
    $router->post('/account/fundtransfer', "MemberController@account_fundtransfer_post");
    $router->get('/account/withdraw', ['as'=>"member.account.withdraw", 'uses'=>"MemberController@account_withdraw"]);
    $router->post('/account/withdraw', "MemberController@account_withdraw_post");

    $router->get('/direct_team', ['as'=>"member.list.direct", 'uses'=>"MemberController@direct_team"]);
    $router->get('/self_team', ['as'=>"member.list.self", 'uses'=>"MemberController@self_team"]);
    $router->get('/all_team', ['as'=>"member.list.all", 'uses'=>"MemberController@all_team"]);

    $router->get('/epin/details', ['as'=>"member.epin.details", 'uses'=>"MemberController@epins"]);
    $router->get('/epin/generate', ['as'=>"member.epin.generate", 'uses'=>"MemberController@epin_generate"]);
    $router->get('/epin/topup', ['as'=>"member.epin.topup", 'uses'=>"MemberController@epin_topup"]);
    $router->get('/epin/transfer', ['as'=>"member.epin.transfer", 'uses'=>"MemberController@epin_transfer"]);

    $router->post('/epin/generate', "MemberController@epin_generate_post");
    $router->post('/epin/topup', "MemberController@epin_topup_post");
    $router->post('/epin/transfer', "MemberController@epin_transfer_post");
    $router->post('/reg_details', ['as'=>"member.reg_details", 'uses'=>"Controller@member_reg"]);

    $router->get('/setting', ['as'=>"member.setting", 'uses'=>"MemberController@setting"]);
    $router->post('/setting', "MemberController@change_password");
    $router->get('/profile', ['as'=>"member.profile", 'uses'=>"MemberController@profile"]);
    $router->post('/profile', "MemberController@post_profile");

    $router->get('/kyc', ['as'=>"member.kyc", 'uses'=>"MemberController@kyc"]);
    $router->post('/kyc', "MemberController@post_kyc");
    $router->post('/upload/photo', ['as'=>"member.photo", 'uses'=>"MemberController@profile_photo"]);

    $router->get('/test', ['as'=>"member.test", 'uses'=>"MemberController@test"]);
    $router->get('/otp', ['as'=>"member.otp", 'uses'=>"MemberController@send_otp"]);
    $router->get('/logout', ['as'=>"member.logout", 'uses'=>"MemberController@logout"]);
});

$router->group(['middleware' => 'admin', 'prefix' => 'admin'], function () use ($router) {
    $router->get('/dashboard', ['as'=>"admin.dashboard", 'uses'=>"AdminController@dashboard"]);

    $router->get('/epin', ['as'=>"admin.epin", 'uses'=>"AdminController@epin"]);
    $router->post('/epin', "AdminController@post_epin");

    $router->get('/pinpoint', ['as'=>"admin.pinpoint", 'uses'=>"AdminController@pinpoint"]);
    $router->post('/pinpoint', "AdminController@post_pinpoint");
    $router->post('/pinpoint/delete', ['as'=>"admin.pinpoint.delete", 'uses'=>"AdminController@delete_pinpoint"]);

    $router->get('/news', ['as'=>"admin.news", 'uses'=>"AdminController@news"]);
    $router->post('/news', "AdminController@post_news");
    $router->post('/news/delete', ['as'=>"admin.news.delete", 'uses'=>"AdminController@delete_news"]);

    $router->get('/member/list', ['as'=>"admin.members", 'uses'=>"AdminController@members"]);
    $router->get('/member/view/{id}', ['as'=>"admin.member.view", 'uses'=>"AdminController@member_view"]);
    $router->post('/member/kyc_update', ['as'=>"admin.member.kyc_update", 'uses'=>"AdminController@kyc_update"]);
    $router->get('/member/edit/{id}', ['as'=>"admin.member.edit", 'uses'=>"AdminController@member_edit"]);
    $router->post('/member/edit/{id}', "AdminController@post_member_edit");
    $router->post('/member/delete', ['as'=>"admin.member.delete", 'uses'=>"AdminController@member_delete"]);

    $router->get('/daily_closing', ['as'=>"admin.daily_closing", 'uses'=>"AdminController@daily_closing"]);
    $router->get('/member/pv', ['as'=>"admin.pv", 'uses'=>"AdminController@member_pv"]);
    $router->get('/member/level', ['as'=>"admin.level", 'uses'=>"AdminController@member_level"]);
    $router->get('/member/total_act', ['as'=>"admin.total_act", 'uses'=>"AdminController@total_act"]);

    $router->get('/member/new_level', ['as'=>"admin.new_level", 'uses'=>"AdminController@new_member_level"]);
    //club_pv
    $router->get('/member/club_pv', "AdminController@club_pv");

    $router->get('/account/payment', ['as'=>"admin.payment", 'uses'=>"AdminController@payment"]);
    $router->post('/account/payment', "AdminController@post_payment");
    $router->get('/account/withdraw', ['as'=>"admin.withdraw", 'uses'=>"AdminController@withdraw"]);
    $router->post('/account/withdraw', "AdminController@post_withdraw");

    $router->get('/report/registration', ['as'=>"admin.report_reg", 'uses'=>"AdminController@report_reg"]);
    $router->post('/report/registration', "AdminController@get_report_reg");
    $router->get('/report/epin', ['as'=>"admin.report_epin", 'uses'=>"AdminController@report_epin"]);
    $router->post('/report/epin', "AdminController@get_report_epin");

    $router->get('/wallet/transfer', ['as'=>"admin.wallet.transfer", 'uses'=>"AdminController@transfer"]);
    $router->post('/wallet/transfer', "AdminController@transfer_post");
    $router->get('/wallet/adjustment', ['as'=>"admin.wallet.adjustment", 'uses'=>"AdminController@adjustment"]);
    $router->post('/wallet/adjustment', "AdminController@adjustment_post");

    $router->get('/change_password', ['as'=>"admin.change_password", 'uses'=>"AdminController@change_password"]);
    $router->post('/change_password', "AdminController@post_change_password");

    $router->get('/logout', ['as'=>"admin.logout", 'uses'=>"AdminController@logout"]);
});
