<?=$this->get_message()?>
<section class="admin-logged admin-dashboard text-center">
    <div id="site-settings">
        <h3>الألفاظ الممنوعه</h3>
        <form class="text-right" id="edit-question-form" action="/admin/forbidden_words/update" method="POST" enctype="multipart/form-data">
            <?=$this->_token();?>
            <div class="form-group">
                <textarea name="bad_words" id="bad_words" class="form-control" placeholder="الألفاظ الممنوعه(اكتب الكلمات وافصل بينهم بفصله , )"><?=$this->words?></textarea>
            </div>
            <div class="form-group text-center">
                <button class="btn main-btn" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</section>