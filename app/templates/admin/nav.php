<!--Start Navbar-->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#ournavbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand hvr-pulse-shrink visible-xs" href="/">
                <img src="<?=IMGS?>logo_small.png" alt="Logo">
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="ournavbar">
            <ul class="nav navbar-nav navbar-right side-nav" style="border-<?=$this->__('settings.reverse-align')?>: 1px solid #899afb26;<?=$this->__('settings.align')?>: 0;">
                <div class="text-center">
                    <a class="navbar-brand hidden-xs" href="/">
                        <img src="<?=IMGS?>logo.png" alt="Logo">
                    </a>
                </div>
                <?php if(in_array($this->current_user(),[USER,BOTH])): ?>
                <li class="be-listener-parent">
                    <a class="btn main-btn be-listener" href="#">
                        <span>
                            <?php if($this->__("settings.align") == "right"): ?>
                                <i class="fa fa-search" style="margin-<?=$this->__("settings.align")?>:5px;"></i>
                            <?php endif;?>
                            <?=$this->__('user.nav.find_a_listener')?>   
                            <?php if($this->__("settings.align") == "left"): ?>
                                <i class="fa fa-search" style="margin-<?=$this->__("settings.align")?>:5px;"></i>
                            <?php endif;?>                             
                        </span>
                    </a>
                </li>
                <?php endif; ?>
                <li <?=$this->active_page == 'dashboard' ? 'class="active"' : "" ?>>
                    <a href="/admin/dashboard">لوحة التحكم</a>
                </li>
                <li <?=$this->active_page == 'users' ? 'class="active"' : "" ?>>
                    <a href="/admin/users">المستخدمين</a>
                </li>
                <?php if($this->get_session("id") == OWNER_ID): ?>
                <li <?=$this->active_page == 'supervisors' ? 'class="active"' : "" ?>>
                    <a href="/admin/supervisors">المشرفون</a>
                </li>
                <li <?=$this->active_page == 'forbidden_words' ? 'class="active"' : "" ?>>
                    <a href="/admin/forbidden_words">الألفاظ الممنوعه</a>
                </li>
                <?php endif; ?>
                <li <?=$this->active_page == 'messages' ? 'class="active"' : "" ?>>
                    <a href="/admin/messages">الرسائل</a>
                </li>
                <li <?=$this->active_page == 'problems' ? 'class="active"' : "" ?>>
                    <a href="/admin/problems">الابلاغات</a>
                </li>
                <li <?=$this->active_page == 'archive' ? 'class="active"' : "" ?>>
                    <a href="/admin/archive">الأرشيف</a>
                </li>
                <li <?=$this->active_page == 'questions' ? 'class="active"' : "" ?>>
                    <a href="/admin/questions">أسئلة المستمع</a>
                </li>
                <li <?=$this->active_page == 'site_settings' ? 'class="active"' : "" ?>>
                    <a href="/admin/site_settings">اعدادات الموقع</a>
                </li>
                <li <?=$this->active_page == 'site_settings_ltr' ? 'class="active"' : "" ?>>
                    <a href="/admin/site_settings_ltr">(ltr) اعدادات الموقع</a>
                </li>
                <li <?=$this->active_page == 'profile_settings' ? 'class="active"' : "" ?>>
                    <a href="/admin/profile_settings">اعدادات الصفحه الشخصيه</a>
                </li>
                <li>
                    <a href="/admin/logout">تسجيل الخروج</a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<!--End Navbar-->