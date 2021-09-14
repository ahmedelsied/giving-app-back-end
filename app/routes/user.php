<?php
namespace routes;

// Start Auth Routes
$this->routes->post("/api/user/login","api\user\auth\login_controller@login");
$this->routes->post("/api/user/login-with-huawei","api\user\auth\login_controller@login_with_huawei");
$this->routes->post("/api/user/sign-up","api\user\auth\signup_controller@signup");
$this->routes->post("/api/user/sign-up-with-huawei","api\user\auth\signup_controller@sign_up_with_huawei");
$this->routes->post("/api/user/active-code","api\user\auth\\verfication_controller@active_code");
$this->routes->post("/api/user/resend-active-code","api\user\auth\\verfication_controller@resend_active_code");
$this->routes->post("/api/user/forget-password","api\user\auth\password_recovery_controller@forget_password");
$this->routes->post("/api/user/resend-recovery-code","api\user\auth\password_recovery_controller@resend_recover_code");
$this->routes->post("/api/user/check-recovery-code","api\user\auth\password_recovery_controller@check_recovery_code");
$this->routes->post("/api/user/create-new-password","api\user\auth\password_recovery_controller@create_new_password");
// End Auth Routes

// Start Item Routes
$this->routes->get("/api/user/item/accepted","api\user\item_controller@get_accepted")->middleware("auth_user");
$this->routes->get("/api/user/item/pending","api\user\item_controller@get_pending")->middleware("auth_user");
$this->routes->get("/api/user/item/get-categories","api\user\item_controller@get_categories")->middleware("auth_token");
$this->routes->get("/api/user/item/get-item-img","api\user\item_controller@get_item_img");
$this->routes->get("/api/user/item","api\user\item_controller@item")->middleware("auth_token");
$this->routes->delete("/api/user/item/delete","api\user\item_controller@delete")->middleware("auth_user");
$this->routes->post("/api/user/item/update-item-img","api\user\item_controller@update_item_img")->middleware("auth_user");
$this->routes->post("/api/user/item/add","api\user\item_controller@add")->middleware("is_phone_active");
$this->routes->put("/api/user/item/update","api\user\item_controller@update")->middleware("auth_user");
// End Item Routes

// Start User Profile
$this->routes->put("/api/user/profile/update-full-name","api\user\profile_controller@update_full_name")->middleware("auth_user");
$this->routes->put("/api/user/profile/update-email","api\user\profile_controller@update_email")->middleware("auth_user");
$this->routes->put("/api/user/profile/update-password","api\user\profile_controller@update_password")->middleware("auth_user");
$this->routes->post("/api/user/profile/update-profile-img","api\user\profile_controller@update_profile_img")->middleware("auth_user");
$this->routes->put("/api/user/profile/update-phone-number","api\user\profile_controller@update_phone_number")->middleware("auth_user");
$this->routes->put("/api/user/profile/active-phone-number","api\user\profile_controller@active_phone_number")->middleware("auth_user");
$this->routes->get("/api/user/profile/get-user-img","api\user\profile_controller@get_user_img");
$this->routes->delete("/api/user/profile/delete-account","api\user\profile_controller@delete_account")->middleware("auth_user");
// End User Profile

// Start User Request
$this->routes->get("/api/user/request/all","api\user\\request_controller@get_all")->middleware("auth_user");
$this->routes->put("/api/user/request/make","api\user\\request_controller@make")->middleware("is_phone_active,is_exceed_request_limit");
$this->routes->put("/api/user/request/delete","api\user\\request_controller@delete")->middleware("auth_user");
$this->routes->put("/api/user/request/accept","api\user\\request_controller@accept")->middleware("auth_user");
$this->routes->put("/api/user/request/delivered","api\user\\request_controller@delivered")->middleware("auth_user");
$this->routes->put("/api/user/request/refuse","api\user\\request_controller@refuse")->middleware("auth_user");
// End User Request

// Start Home
$this->routes->get("/api/user/home","api\user\home_controller@home_items")->middleware("auth_user");
$this->routes->get("/api/user/home/search","api\user\home_controller@search")->middleware("auth_user");
$this->routes->get("/api/user/home/filter","api\user\home_controller@filter")->middleware("auth_user");
// End Home
