<?=$this->get_message()?>
<section class="admin admin-login text-center">
    <div class="login-parent">    
        <div class="logo">
            <img src="<?=IMGS?>logo.png" alt="" srcset="">
        </div>
        <h2 class="h1 main-color"><b>تسجيل دخول المشرف</b></h2>
        <form action="/admin/index/login" method="POST" class="form-group">
            <?=$this->_token()?>
            <div>
                <input type="text" name="user_name" placeholder="اكتب اسم المستخدم" class="form-control" required="required">
            </div>
            <div>
                <input type="password" name="password" placeholder="اكتب كلمة السر" class="form-control" required="required">
            </div>
            <button class="btn main-btn login-btn">تسجيل الدخول</button>
        </form>
    </div>
</section>