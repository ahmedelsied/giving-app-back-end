<?=$this->get_message()?>
<section class="admin-logged admin-dashboard text-center">
    <div id="site-settings">
        <h3>إضافة مستخدم</h3>
        <form class="text-right" id="add-users" action="/admin/users/create" method="POST" enctype="multipart/form-data">
            <?=$this->_token()?>
            <div class="form-group">
                <label for="main-page">الاسم بالكامل</label>
                <input name="full_name" type="text" class="form-control" placeholder="الاسم بالكامل" required="required"/>
            </div>
            <div class="form-group">
                <label for="main-page">البريد الالكتروني</label>
                <input name="email" type="email" class="form-control" placeholder="البريد الالكتروني" required="required"/>
            </div>
            <div class="form-group">
                <label for="main-page">المدينه</label>
                <input name="city" type="city" class="form-control" placeholder="المدينه" required="required"/>
            </div>
            <div class="form-group">
                <label for="main-page">النوع</label>
            <div class="form-group">
                <select style="padding-top: 0px;" required="required" class="border-main-color form-control" name="gender" id="gender">
                    <option value="" selected disabled="disabled">النوع</option>
                    <option value="0">ذكر</option>
                    <option value="1">أنثى</option>
                    <option value="2">آخر</option>
                </select>
            </div>
            </div>
            <div class="form-group" style="position:relative">
                <label style="right: 4%;text-align: right;" id="birthdate-label">تاريخ الميلاد</label>
                <input class="border-main-color form-control" id="birthdate" name="birthdate" placeholder="تاريخ الميلاد" type="date" required="required"/>
            </div>
            <div class="form-group">
                <label for="about-us">الرقم السري</label>
                <input name="password" type="password" class="form-control" placeholder="أدخل الرقم السري" required="required"/>
            </div>
            <div class="form-group">
                <label for="about-us">تأكيد الرقم السري</label>
                <input name="cnfrm-pass" type="password" class="form-control" placeholder="أدخل الرقم السري مره أخرى" required="required"/>
            </div>
            <div class="filter text-right">
                <input name="user-type" type="radio" id="listener" value="<?=LISTENER?>" required="required"/>
                <label for="listener">مستمع</label>
                <input name="user-type" type="radio" id="user" value="<?=USER?>" required="required"/>
                <label for="user">مستخدم عادي</label>
                <input name="user-type" type="radio" id="both" value="<?=BOTH?>" required="required"/>
                <label for="both">الصلاحيتين</label>
            </div>
            <div class="form-group text-center">
                <button class="btn main-btn" type="submit">اضافه</button>
            </div>
        </form>
    </div>
</section>