<?=$this->get_message()?>
<section class="admin-logged admin-dashboard text-center">
    <div id="site-settings">
        <h3>تعديل مستخدم</h3>
        <a href="/admin/users/<?=$this->user_data['banned'] ? "unban" : "ban"?>/<?=$this->user_data['id']?>" class="btn ban-btn"><?=$this->user_data['banned'] ? "إلغاء الحظر" : "حظر"?> </a>
        <form class="text-right" id="add-users" action="/admin/users/update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?=$this->user_data['id']?>">
            <?=$this->_token()?>
            <div class="form-group">
                <label for="main-page">الاسم بالكامل</label>
                <input name="full_name" type="text" class="form-control" placeholder="الاسم بالكامل" required="required" value="<?=$this->user_data['full_name']?>"/>
            </div>
            <?php if($this->is_native_user): ?>
            <div class="form-group">
                <label for="main-page">البريد الالكتروني</label>
                <input name="email" type="email" class="form-control" placeholder="البريد الالكتروني" required="required" value="<?=$this->user_data['email']?>"/>
            </div>
            <div class="form-group">
                <label for="main-page">المدينه</label>
                <input name="city" type="city" class="form-control" placeholder="المدينه" required="required" value="<?=$this->user_data['city']?>"/>
            </div>
            <div class="form-group">
                <label for="main-page">النوع</label>
            <div class="form-group">
                <select style="padding-top: 0px;" required="required" class="border-main-color form-control" name="gender" id="gender">
                    <option value="" selected disabled="disabled">النوع</option>
                    <option value="0" <?=$this->eq_field($this->user_data['gender'],MALE) ? "selected" : ""?> >ذكر</option>
                    <option value="1" <?=$this->eq_field($this->user_data['gender'],FEMALE)? "selected" : ""?> >أنثى</option>
                    <option value="2" <?=$this->eq_field($this->user_data['gender'],OTHER)? "selected" : ""?> >آخر</option>
                </select>
            </div>
            </div>
            <div class="form-group" style="position:relative">
                <label style="right: 4%;text-align: right;" id="birthdate-label">تاريخ الميلاد</label>
                <input class="border-main-color form-control" id="birthdate" name="birthdate" placeholder="تاريخ الميلاد" type="date" required="required" value="<?=$this->user_data['birthdate']?>"/>
            </div>
            <div class="form-group">
                <label for="about-us">الرقم السري</label>
                <input name="password" type="password" class="form-control" placeholder="أدخل الرقم السري"/>
            </div>
            <div class="form-group">
                <label for="about-us">تأكيد الرقم السري</label>
                <input name="cnfrm-pass" type="password" class="form-control" placeholder="أدخل الرقم السري مره أخرى"/>
            </div>
            <?php else:?>
            <div class="text-center">
                <p class="lead">يبدو أن هذا المستخدم مسجل من قبل جوجل أو فيسبوك</p>
                <p class="lead">وبالتالي هناك بعض المعلومات لن تكون متاحه</p>
            </div>
            <?php endif;?>
            <div class="filter text-right">
                <input name="user-type" type="radio" id="listener" <?=$this->eq_field($this->user_data['type'],LISTENER) ? "checked" : ""?> value="<?=LISTENER?>" required="required"/>
                <label for="listener">مستمع</label>
                <input name="user-type" type="radio" id="user" <?=$this->eq_field($this->user_data['type'],USER) ? "checked" : ""?> value="<?=USER?>" required="required"/>
                <label for="user">مستخدم عادي</label>
                <input name="user-type" type="radio" id="both" <?=$this->eq_field($this->user_data['type'],BOTH) ? "checked" : ""?> value="<?=BOTH?>" required="required"/>
                <label for="both">الصلاحيتين</label>
            </div>
            <div class="form-group text-center">
                <button class="btn main-btn" type="submit">اضافه</button>
            </div>
        </form>
    </div>
</section>